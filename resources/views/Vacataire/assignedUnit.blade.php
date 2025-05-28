<x-layout title="Assigned Teaching Units">

    <x-slot:head>
        @vite([
            'resources/css/vacataire/assigned-units.css',
            'resources/css/components/popup.css',
            'resources/css/components/chips.css',
            'resources/js/components/chips.js'
        ])
    </x-slot:head>

    <x-nav></x-nav>

<div class="main-container">

    <div class="desktop">
        <x-table>
            <table>
                <tr>
                    <th><div class="th-wrapper">id</div></th>
                    <th><div class="th-wrapper">name</div></th>
                    <th><div class="th-wrapper">description</div></th>
                    <th><div class="th-wrapper">hours</div></th>
                    <th><div class="th-wrapper">credits</div></th>
                    <th><div class="th-wrapper">major</div></th>
                    <th><div class="th-wrapper">semester</div></th>
                </tr>
                @foreach($assignments as $assignment)
                    <tr>
                        <td><div class="td-wrapper">{{ $assignment->teachingUnit->id }}</div></td>
                        <td><div class="td-wrapper">{{ $assignment->teachingUnit->name }}</div></td>
                        <td><div class="td-wrapper">{{ $assignment->teachingUnit->description }}</div></td>
                        <td><div class="td-wrapper">{{ $assignment->teachingUnit->hours }}</div></td>
                        <td><div class="td-wrapper">{{ $assignment->teachingUnit->credits }}</div></td>
                        <td>
                            <div class="td-wrapper">
                                <span class="chip" data-status="{{ strtolower($assignment->teachingUnit->filiere->name) }}">
                                    {{ $assignment->teachingUnit->filiere->name }}
                                </span>
                            </div>
                        </td>
                        <td><div class="td-wrapper">{{ $assignment->teachingUnit->semester }}</div></td>
                    </tr>
                @endforeach
            </table>
        </x-table>
    </div>

    <div class="mobile">
        <div class="cards-grid">
            @foreach($assignments as $assignment)
                <div class="card">
                    <div class="card-header">
                        <div class="card-id">#{{ $assignment->teachingUnit->id }}</div>
                        <span class="chip" data-status="{{ strtolower($assignment->teachingUnit->filiere->name) }}">
                            {{ $assignment->teachingUnit->filiere->name }}
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="info-row">
                            <span class="label">Name:</span>
                            <span class="value">{{ $assignment->teachingUnit->name }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Description:</span>
                            <span class="value">{{ $assignment->teachingUnit->description }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Hours:</span>
                            <span class="value">{{ $assignment->teachingUnit->hours }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Credits:</span>
                            <span class="value">{{ $assignment->teachingUnit->credits }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Semester:</span>
                            <span class="value">{{ $assignment->teachingUnit->semester }}</span>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($assignments instanceof \Illuminate\Pagination\LengthAwarePaginator && $assignments->hasPages())
        <div class="pagination">
            <a href="{{ $assignments->previousPageUrl() }}" class="prev-btn {{ $assignments->onFirstPage() ? 'disabled' : '' }}">< previous</a>
            <span class="page-info">{{ $assignments->currentPage() }} | {{ $assignments->lastPage() }}</span>
            <a href="{{ $assignments->nextPageUrl() }}" class="next-btn {{ $assignments->hasMorePages() ? '' : 'disabled' }}">next ></a>
        </div>
    @endif

{{--    <div class="summary">--}}
{{--        <p>You are assigned to {{ $assignments->count() }} Teaching Units</p>--}}
{{--    </div>--}}

</div>
</x-layout>
