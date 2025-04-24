<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/js/Vacataire/assessments.js')
    <title>Document</title>
</head>
<body>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <h1>Hello To The Assessment Page</h1>
    <p>Welcome to the assessment page. Here you can find all the information related to your assessments.</p>

    <button onclick="window.location='{{ route('Vacataire.AddAssessments') }}'">Add New Assessments</button>

    @if ($errors->any())
        <div class="alert alert-danger" style="color: red;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($assessments->isEmpty())
        <p>You have no assessments available at the moment.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Assessment ID</th>
                <th>Assessment Name</th>
                <th>Assessment Description</th>
                <th>Filiere</th>
                <th>Semester</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($assessments as $assessment)
                <tr>
                    <td>{{ $assessment->id }}</td>
                    <td>{{ $assessment->name }}</td>
                    <td>{{ $assessment->description }}</td>
                    <td>{{ $assessment->filiere->name }}</td>
                    <td>{{ $assessment->semester }}</td>
                    <td>
                        @if($assessment->hasGrades())
                            <form action="{{ route('Vacataire.grades.export') }}" method="POST">
                                @csrf
                                <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                <button type="submit">Export Grades</button>
                            </form>

                            {{-- Upload Normal Grade --}}
                            <form id="uploadForm-normal-{{ $assessment->id }}" action="{{ route($assessment->hasNormalGrades() ? 'Vacataire.grades.upload' : 'Vacataire.grades.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                <input type="file" name="file" id="fileInput-normal-{{ $assessment->id }}" style="display: none;">
                                <button type="button" class="upload-button" data-id="{{ $assessment->id }}" data-type="normal">
                                    {{ $assessment->hasNormalGrades() ? 'Upload New Normal Grade' : 'Upload Normal Grade' }}
                                </button>
                            </form>

                            {{-- Upload Retake Grade --}}
                            <form id="uploadForm-retake-{{ $assessment->id }}" action="{{ route($assessment->hasRetakeGrades() ? 'Vacataire.NewRetakegrades.upload' : 'Vacataire.Retakegrades.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                <input type="file" name="file" id="fileInput-retake-{{ $assessment->id }}" style="display: none;">
                                <button type="button" class="upload-button" data-id="{{ $assessment->id }}" data-type="retake">
                                    {{ $assessment->hasRetakeGrades() ? 'Upload New Retake Grade' : 'Upload Retake Grade' }}
                                </button>
                            </form>
                        @else
                            {{-- First-time Normal Grade Upload --}}
                            <form id="uploadForm-normal-{{ $assessment->id }}" action="{{ route('Vacataire.grades.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                                <input type="file" name="file" id="fileInput-normal-{{ $assessment->id }}" style="display: none;">
                                <button type="button" class="upload-button" data-id="{{ $assessment->id }}" data-type="normal">Upload Normal Grade</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
