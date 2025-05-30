<x-layout title="Assessments">

    <x-slot:head>
        @vite([
            'resources/css/vacataire/assessments.css',
            'resources/css/components/popup.css',
            'resources/css/components/chips.css',
            'resources/js/components/chips.js',
            'resources/js/Vacataire/assessments.js'
        ])
    </x-slot:head>

    <x-nav></x-nav>

<div class="main-container">
    <div class="header-section">
{{--        <h1>Assessments</h1>--}}
{{--        <p>Welcome to the assessment page. Here you can find all the information related to your assessments.</p>--}}
        <button class="primary-button" onclick="window.location='{{ route('Vacataire.AddAssessments') }}'">Add New Assessments</button>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="desktop">
        <x-table>
            <table>
                <tr>
                    <th><div class="th-wrapper">ID</div></th>
                    <th><div class="th-wrapper">Name</div></th>
                    <th><div class="th-wrapper">Description</div></th>
                    <th><div class="th-wrapper">Major</div></th>
                    <th><div class="th-wrapper">Semester</div></th>
                    <th><div class="th-wrapper">Actions</div></th>
                </tr>
                @foreach($assessments as $assessment)
                    <tr>
                        <td><div class="td-wrapper">{{ $assessment->id }}</div></td>
                        <td><div class="td-wrapper">{{ $assessment->name }}</div></td>
                        <td><div class="td-wrapper">{{ $assessment->description }}</div></td>
                        <td><div class="td-wrapper">
                            <span class="chip" data-status="{{ strtolower($assessment->filiere->name) }}">
                                {{ $assessment->filiere->name }}
                            </span>
                        </div></td>
                        <td><div class="td-wrapper">{{ $assessment->semester }}</div></td>
                        <td>
                            <div class="td-wrapper actions-wrapper">
                                @if($assessment->hasGrades())
                                    <form class="action-form" action="{{ route('Vacataire.grades.export') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                        <button type="submit" class="action-button">Export Grades</button>
                                    </form>

                                    {{-- Upload Normal Grade --}}
                                    <form class="action-form" id="uploadForm-normal-{{ $assessment->id }}" action="{{ route($assessment->hasNormalGrades() ? 'Vacataire.grades.upload' : 'Vacataire.grades.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                        <input type="file" name="file" id="fileInput-normal-{{ $assessment->id }}" style="display: none;">
                                        <button type="button" class="action-button upload-button" data-id="{{ $assessment->id }}" data-type="normal">
                                            {{ $assessment->hasNormalGrades() ? 'Upload New Normal Grade' : 'Upload Normal Grade' }}
                                        </button>
                                    </form>

                                    {{-- Upload Retake Grade --}}
                                    <form class="action-form" id="uploadForm-retake-{{ $assessment->id }}" action="{{ route($assessment->hasRetakeGrades() ? 'Vacataire.NewRetakegrades.upload' : 'Vacataire.Retakegrades.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                        <input type="file" name="file" id="fileInput-retake-{{ $assessment->id }}" style="display: none;">
                                        <button type="button" class="action-button upload-button" data-id="{{ $assessment->id }}" data-type="retake">
                                            {{ $assessment->hasRetakeGrades() ? 'Upload New Retake Grade' : 'Upload Retake Grade' }}
                                        </button>
                                    </form>
                                @else
                                    {{-- First-time Normal Grade Upload --}}
                                    <form class="action-form" id="uploadForm-normal-{{ $assessment->id }}" action="{{ route('Vacataire.grades.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                        <input type="file" name="file" id="fileInput-normal-{{ $assessment->id }}" style="display: none;">
                                        <button type="button" class="action-button upload-button" data-id="{{ $assessment->id }}" data-type="normal">Upload Normal Grade</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if(!$assessments || $assessments->isEmpty())
                    <tr>
                        <td class="colspan-all">
                            <div class="empty-table">
                                <img src="{{asset('png/no-data-found.jpg')}}" alt="no data found img">
                                <p><span><strong>Oops,</strong></span><br>No Data Found!</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </table>
        </x-table>
    </div>

    <div class="mobile">
        <div class="cards-grid">
            @foreach($assessments as $assessment)
                <div class="card">
                    <div class="card-header">
                        <div class="card-id">#{{ $assessment->id }}</div>
                        <span class="chip" data-status="{{ strtolower($assessment->filiere->name) }}">
                            {{ $assessment->filiere->name }}
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="info-row">
                            <span class="label">Name:</span>
                            <span class="value">{{ $assessment->name }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Description:</span>
                            <span class="value">{{ $assessment->description }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Semester:</span>
                            <span class="value">{{ $assessment->semester}}</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="actions-container">
                            @if($assessment->hasGrades())
                                <form class="action-form" action="{{ route('Vacataire.grades.export') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                    <button type="submit" class="action-button">Export Grades</button>
                                </form>

                                {{-- Upload Normal Grade --}}
                                <form class="action-form" id="uploadForm-normal-mobile-{{ $assessment->id }}" action="{{ route($assessment->hasNormalGrades() ? 'Vacataire.grades.upload' : 'Vacataire.grades.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                    <input type="file" name="file" id="fileInput-normal-mobile-{{ $assessment->id }}" style="display: none;">
                                    <button type="button" class="action-button upload-button" data-id="{{ $assessment->id }}" data-type="normal" data-mobile="true">
                                        {{ $assessment->hasNormalGrades() ? 'Upload New Normal Grade' : 'Upload Normal Grade' }}
                                    </button>
                                </form>

                                {{-- Upload Retake Grade --}}
                                <form class="action-form" id="uploadForm-retake-mobile-{{ $assessment->id }}" action="{{ route($assessment->hasRetakeGrades() ? 'Vacataire.NewRetakegrades.upload' : 'Vacataire.Retakegrades.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                    <input type="file" name="file" id="fileInput-retake-mobile-{{ $assessment->id }}" style="display: none;">
                                    <button type="button" class="action-button upload-button" data-id="{{ $assessment->id }}" data-type="retake" data-mobile="true">
                                        {{ $assessment->hasRetakeGrades() ? 'Upload New Retake Grade' : 'Upload Retake Grade' }}
                                    </button>
                                </form>
                            @else
                                {{-- First-time Normal Grade Upload --}}
                                <form class="action-form" id="uploadForm-normal-mobile-{{ $assessment->id }}" action="{{ route('Vacataire.grades.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                    <input type="file" name="file" id="fileInput-normal-mobile-{{ $assessment->id }}" style="display: none;">
                                    <button type="button" class="action-button upload-button" data-id="{{ $assessment->id }}" data-type="normal" data-mobile="true">Upload Normal Grade</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="card">
                <div class="card-body">
                    @if(!$assessments || $assessments->isEmpty())
                        <div class="empty-table">
                            <img src="{{asset('png/no-data-found.jpg')}}" alt="no data found img">
                            <p><span><strong>Oops,</strong></span><br>No Data Found!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($assessments instanceof \Illuminate\Pagination\LengthAwarePaginator && $assessments->hasPages())
        <div class="pagination">
            <a href="{{ $assessments->previousPageUrl() }}" class="prev-btn {{ $assessments->onFirstPage() ? 'disabled' : '' }}">< previous</a>
            <span class="page-info">{{ $assessments->currentPage() }} | {{ $assessments->lastPage() }}</span>
            <a href="{{ $assessments->nextPageUrl() }}" class="next-btn {{ $assessments->hasMorePages() ? '' : 'disabled' }}">next ></a>
        </div>
    @endif
</div>
</x-layout>
