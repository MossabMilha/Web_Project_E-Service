<x-layout title="professors">

    <x-slot:head>
        @vite([
        'resources/js/components/user-role-styling.js',
        'resources/css/DepartmentHead/professors/index.css',
        'resources/js/department-head/professors/index.js',
        'resources/css/components/popup.css',
        'resources/js/components/popup.js',
        'resources/css/components/chips.css',
        'resources/js/components/chips.js',
        'resources/css/DepartmentHead/professors/assign-units-popup.css',
        'resources/js/department-head/professors/assign-units-popup.js'
        ])
    </x-slot:head>

    <x-nav/>

    <body>
        <div class="main-container">
            {{--    <div class="search-wrapper">--}}
            {{--        <form class="search-form" method="GET" action="">--}}
            {{--            <div class="search-bar">--}}
            {{--                <input type="text" id="search" name="search" placeholder="Search">--}}
            {{--                <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}"--}}
            {{--                                                              alt="Search Icon"></button>--}}
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
            {{--        --}}{{--        <form class="add-user-form" method="GET" action="{{ route('UserManagement.adduser') }}">--}}
            {{--        --}}{{--            <button class="add-btn" type="submit">+ Add New User</button>--}}
            {{--        --}}{{--        </form>--}}
            {{--    </div>--}}
            <x-table>
                <table>
                    <thead>
                    <tr>
                        <th><div class="th-wrapper">User Id</div></th>
                        <th><div class="th-wrapper">Full Name</div></th>
                        <th><div class="th-wrapper">Email</div></th>
                        <th><div class="th-wrapper">Role</div></th>
                        <th><div class="th-wrapper">Specialisation</div></th>
                        <th><div class="th-wrapper">Created At</div></th>
                        <th><div class="th-wrapper">Updated At</div></th>
                        <th><div class="th-wrapper">Action</div></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($profsWithUnits as $data)
                        @php
                            $professor = $data['professor'];
                            $units = $data['units']
                        @endphp

                            <!-- Main Professor Row -->
                        <tr>
                            <td><div class="td-wrapper">{{ $professor->id }}</div></td>
                            <td><div class="td-wrapper">{{ $professor->name }}</div></td>
                            <td><div class="td-wrapper">{{ $professor->email }}</div></td>
                            <td><div class="td-wrapper role">{{ $professor->role }}</div></td>
                            <td><div class="td-wrapper">{{ $professor->specialization }}</div></td>
                            <td><div class="td-wrapper">{{ $professor->created_at }}</div></td>
                            <td><div class="td-wrapper">{{ $professor->updated_at }}</div></td>
                            <td><div  class="td-wrapper toggle-units">more</div></td>
                        </tr>

                        <!-- Nested Units Table -->
                        @if($units->isNotEmpty())
                            <tr class="nested-row" id="units-{{ $professor->id }}" style="display: none;">
                                <td colspan="8">
                                    <div class="nested-content">
                                        <table class="nested-units-table">
                                            <thead>
                                            <tr>
                                                <th class="nested"><div class="th-wrapper">Unit ID</div></th>
                                                <th class="nested"><div class="th-wrapper">Unit Name</div></th>
                                                <th class="nested"><div class="th-wrapper">Unit Hours</div></th>
                                                <th class="nested"><div class="th-wrapper">Credits</div></th>
                                                <th class="nested"><div class="th-wrapper">Semester</div></th>
                                                <th class="nested"><div class="th-wrapper">Status</div></th>
                                                <th class="nested"><div class="th-wrapper">Action</div></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($units as $unit)
                                                <tr>
                                                    <td class="nested"><div class="td-wrapper">{{ $unit->id }}</div></td>
                                                    <td class="nested"><div class="td-wrapper">{{ $unit->name }}</div></td>
                                                    <td class="nested"><div class="td-wrapper">{{ $unit->hours }}</div></td>
                                                    <td class="nested"><div class="td-wrapper">{{ $unit->credits }}</div></td>
                                                    <td class="nested"><div class="td-wrapper">{{ $unit->semester }}</div></td>
                                                    <td class="nested">
                                                        <div class="td-wrapper">
                                                            <span class="chip" data-status="{{ $unit->assignmentStatus()}}">
                                                                {{ $unit->assignmentStatus()}}
                                                            </span>

                                                        </div>
                                                    </td>
                                                    <td class="nested">
                                                        <div class="td-wrapper">
                                                            <form action="{{ route('department-head.professors.units.destroy', ['professor_id' => $professor->id, 'unit_id' => $unit->id]) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <x-svg-icon src="svg/remove-paper-icon.svg" stroke="var(--color-danger)"/>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        <button type="button"
                                                                class="open-popup-btn open-assign-popup-btn"
                                                                data-professor-id="{{ $professor->id }}">
                                                            Assign Unit(s)
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @endif

                    @endforeach
                    </tbody>
                </table>
            {{--    @if ($units->hasPages())--}}
            {{--        <div class="pagination">--}}
            {{--            <a href="{{ $units->previousPageUrl() }}" class="prev-btn {{ $units->onFirstPage() ? 'disabled' : '' }}"><--}}
            {{--                previous</a>--}}
            {{--            <span class="page-info">{{ $units->currentPage() }} | {{ $units->lastPage() }}</span>--}}
            {{--            <a href="{{ $units->nextPageUrl() }}" class="next-btn {{ $units->hasMorePages() ? '' : 'disabled' }}">next--}}
            {{--                ></a>--}}
            {{--        </div>--}}
            {{--    @endif--}}
            </x-table>
        </div>
        <x-popup>
            <form id="units-assignment-form" action="{{ route('department-head.professors.units.store', 'PROFESSOR_ID') }}" method="post">
                @csrf
                <h2>Assign Units</h2>

                <div class="form-group">
                    <label for="unit-selector">Select Unit:</label>
                    <select id="unit-selector" name="unit_id" class="form-select">
                        <option value="0" selected disabled>Select a unit</option>
                        @foreach($unitsToAssign as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="selected-units-header">
                    <h3>Assigned Units:</h3>
                </div>

                <div id="assigned-unit-container" class="assigned-units-container"></div>

                <input type="hidden" name="selected_units" id="unitsInput">
                <input type="hidden" name="semester" value="1">
                <input type="hidden" name="academic_year" value="2024-2025">

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Assign</button>
                </div>
            </form>
        </x-popup>

            <script>
                window.unitsData = @json($unitsToAssign->pluck('name', 'id'));
            </script>
    </body>

{{--    <style>--}}
{{--        /* Nested table styles */--}}
{{--        .nested-row {--}}
{{--            background-color: var(--color-white);--}}
{{--        }--}}

{{--        .nested-units-table th {--}}
{{--            background-color: #e9ecef;--}}
{{--            font-weight: 500;--}}
{{--        }--}}

{{--        .nested-units-table tr:nth-child(even) {--}}
{{--            background-color: #f8f9fa;--}}
{{--        }--}}

{{--        .nested-units-table tr:hover {--}}
{{--            background-color: #e9ecef;--}}
{{--        }--}}


{{--    </style>--}}


</x-layout>
