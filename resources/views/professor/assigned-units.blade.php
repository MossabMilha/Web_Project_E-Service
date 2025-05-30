<x-layout title="Assigned Units">

    <x-slot:head>
        @vite([
            'resources/css/professor/assigned-units.css',
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
                    <th><div class="th-wrapper">major</div></th>
                    <th><div class="th-wrapper">name</div></th>
                    <th><div class="th-wrapper">hours</div></th>
                    <th><div class="th-wrapper">type</div></th>
                    <th><div class="th-wrapper">credits</div></th>
                    <th><div class="th-wrapper">semester</div></th>
                    <th><div class="th-wrapper">status</div></th>
                </tr>
                @foreach($approvedUnits as $unit)
                    <tr>
                        <td><div class="td-wrapper"> {{ $unit->id }}</div></td>

                        <td>
                            <div class="td-wrapper">
                                <span class="chip" data-status="{{ explode(" ", strtolower($unit->filiere->name))[0] }}">
                                    {{ $unit->filiere->name }}
                                </span>
                            </div>
                        </td>
                        <td><div class="td-wrapper"> {{ $unit->name }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->hours }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->type }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->credits }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->semester }}</div></td>
                        <td>
                            <div class="td-wrapper">
                                <span class="chip" data-status="assigned">
                                    assigned
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-table>
    </div>

    <div class="mobile">
        <div class="cards-grid">
            @foreach($approvedUnits as $unit)
                <div class="card">
                    <div class="card-header">
                        <div class="card-id">#{{ $unit->id }}</div>
                        <span class="chip" data-status="assigned">
                            assigned
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="info-row">
                            <span class="label">Label:</span>
                            <span class="value">{{ $unit->name }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">description:</span>
                            <span class="value">{{ $unit->description }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Hours:</span>
                            <span class="value">{{ $unit->hours }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Type:</span>
                            <span class="value">{{ $unit->type }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Credits:</span>
                            <span class="value">{{ $unit->credits }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Semester:</span>
                            <span class="value">{{ $unit->semester }}</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Major:</span>
                            <span class="value">
                                <span class="chip" data-status="{{strtolower($unit->filiere->name)}}">
                                    {{ $unit->filiere->name }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($approvedUnits instanceof \Illuminate\Pagination\LengthAwarePaginator && $approvedUnits->hasPages())
        <div class="pagination">
            <a href="{{ $approvedUnits->previousPageUrl() }}" class="prev-btn {{ $approvedUnits->onFirstPage() ? 'disabled' : '' }}">< previous</a>
            <span class="page-info">{{ $approvedUnits->currentPage() }} | {{ $approvedUnits->lastPage() }}</span>
            <a href="{{ $approvedUnits->nextPageUrl() }}" class="next-btn {{ $approvedUnits->hasMorePages() ? '' : 'disabled' }}">next ></a>
        </div>
    @endif

</div>
</x-layout>
