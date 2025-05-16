<x-layout title="Units">

    <x-slot:head>
        @vite([
            'resources/css/DepartmentHead/TeachingUnits.css',
            'resources/css/components/popup.css',
            'resources/js/components/popup.js',
            'resources/css/components/chips.css',
            'resources/js/components/chips.js',
            'resources/css/DepartmentHead/teaching_units/assign-prof-popup.css',
            'resources/js/department-head/teaching_units/assign-prof-popup.js'
        ])
    </x-slot:head>

    <x-nav></x-nav>

<div class="main-container">

{{--    <div class="search-wrapper">--}}
{{--        <form class="search-form" method="GET" action="{{route('department-head.teaching-units.search')}}">--}}
{{--            <div class="search-bar">--}}
{{--                <input type="text" id="search" name="search" placeholder="Search">--}}
{{--                <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}" alt="Search Icon"></button>--}}
{{--            </div>--}}
{{--            <div class="dropdown">--}}
{{--                <button id="OptionButton" onclick="toggleDropdown()">Select an Option</button>--}}
{{--                <div class="dropdown-content">--}}
{{--                    <a href="#" onclick="selectOption('id')">id</a>--}}
{{--                    <a href="#" onclick="selectOption('name')">name</a>--}}
{{--                    <a href="#" onclick="selectOption('description')">description</a>--}}
{{--                    <a href="#" onclick="selectOption('hours')">hours</a>--}}
{{--                    <a href="#" onclick="selectOption('type')">type</a>--}}
{{--                    <a href="#" onclick="selectOption('semester')">semester</a>--}}
{{--                    <a href="#" onclick="selectOption('status')">status</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <input type="hidden" id="selectedOption" name="option" value="{{ request('option', 'id') }}">--}}
{{--        </form>--}}
{{--    </div>--}}
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
                    <th><div class="th-wrapper">action</div></th>
                </tr>
                @foreach($units as $unit)
                    <tr>
                        <td><div class="td-wrapper"> {{ $unit->id }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->filiere->name }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->name }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->hours }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->type }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->credits }}</div></td>
                        <td><div class="td-wrapper"> {{ $unit->semester }}</div></td>
                        <td>
                            <div class="td-wrapper">
                                <span class="chip" data-status="{{ $unit->assignmentStatus()}}">
                                    {{ $unit->assignmentStatus()}}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="td-wrapper">
                                @if($unit->assignmentStatus() == 'assigned')
                                    <form  method="POST" style="display:inline;" action="{{ route('department-head.professors.units.destroy', ['unit_id' => $unit->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <x-svg-icon src="svg/remove-paper-icon.svg" stroke="var(--color-danger)"/>
                                        </button>
                                    </form>
                                @elseif($unit->assignmentStatus() == 'unassigned')
                                    <button type="button" class="open-popup-btn open-assign-popup-btn">
                                        <x-svg-icon src="svg/add-paper-icon.svg" stroke="var(--color-primary)"/>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-table>
    </div>

    <div class="mobile">
        <div class="cards-grid">
            @foreach($units as $unit)
                <div class="card">
                    <div class="card-header">
                        <div class="card-id">#{{ $unit->id }}</div>
                        <span class="chip" data-status="{{strtolower(explode(' ', $unit->filiere->name)[0])}}">
                            {{ $unit->filiere->name }}
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

                        <div class="card-footer">
                            <div class="icons-wrapper flex">
                                @if($unit->assignmentStatus() == 'assigned')
                                    <form  method="POST" style="display:inline;" action="{{ route('department-head.professors.units.destroy', ['unit_id' => $unit->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <x-svg-icon src="svg/remove-paper-icon.svg" stroke="var(--color-danger)"/>
                                        </button>
                                    </form>
                                @elseif($unit->assignmentStatus() == 'unassigned')
                                    <button type="button" class="open-popup-btn open-assign-popup-btn">
                                        <x-svg-icon src="svg/add-paper-icon.svg" stroke="var(--color-primary)"/>
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($units->hasPages())
        <div class="pagination">
            <a href="{{ $units->previousPageUrl() }}" class="prev-btn {{ $units->onFirstPage() ? 'disabled' : '' }}">< previous</a>
            <span class="page-info">{{ $units->currentPage() }} | {{ $units->lastPage() }}</span>
            <a href="{{ $units->nextPageUrl() }}" class="next-btn {{ $units->hasMorePages() ? '' : 'disabled' }}">next ></a>
        </div>
    @endif

    <x-popup>
        <form id="profs-assignment-form" method="post" action="{{ route('department-head.professors.units.store')}}">
            @csrf
            <h2>Assign Professor</h2>

            <div class="form-group">
                <label for="professor_id">Select Professor:</label>
                <select id="professor_id" name="professor_id" class="form-select" required>
                    <option value="" selected disabled>Select a professor</option>
                    @foreach($professors as $prof)
                        <option value="{{ $prof->id }}">{{ $prof->name }}</option>
                    @endforeach
            </select>
        </div>

        <input type="hidden" name="unit_id" class="unit-id-input">

        <div class="form-actions">
            <button type="submit" class="btn-submit">Assign</button>
        </div>
    </form>
    </x-popup>

</div>
</x-layout>
