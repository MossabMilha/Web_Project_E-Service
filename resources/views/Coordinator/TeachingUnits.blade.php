<x-layout>
    <x-slot:head>
        @vite([
            'resources/js/Coordinator/TeachingUnits.js',
            'resources/js/components/filter-select.js',
            'resources/js/components/popup.js',
            'resources/css/Coordinator/TeachingUnits.css',
            'resources/css/components/filter-select.css',
            'resources/css/components/popup.css',
            'resources/css/components/chips.css',
            'resources/js/components/chips.js'
        ])
    </x-slot:head>

    <x-nav/>

    <div class="main-container">
        <x-popup>
            <form id="add-units-form" method="POST" action="{{ route('Coordinator.AddUnit') }}">
                @csrf

                <img src="{{asset('png/request.jpg')}}" alt="add units" class="popup-img-top">
                <h2 class="text-2xl p-2 mb-4" style="background-color: var(--color-secondary-light); color: var(--color-primary); font-weight: 600">Add New Unit</h2>

                <div class="form-group">
                    <label for="add-name">Name: </label>
                    <input type="text" name="add-name" id="add-name" required>
                </div>

                <div class="form-group">
                    <label for="add-description">Description: </label>
                    <textarea name="add-description" id="add-description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="add-hours">Hours: </label>
                    <input type="number" name="add-hours" id="add-hours" required>
                </div>

                <div class="form-group">
                    <label for="add-type">Type: </label>
                    <div id="add-type">
                        <div class="option">
                            <input type="radio" name="add-type" id="add-cm" value="CM" required>
                            <label for="add-cm">CM</label>
                        </div>

                        <div class="option">
                            <input type="radio" name="add-type" id="add-td" value="TD">
                            <label for="add-td">TD</label>
                        </div>

                        <div class="option">
                            <input type="radio" name="add-type" id="add-tp" value="TP">
                            <label for="add-tp">TP</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="add-credits">Credits: </label>
                    <input type="number" name="add-credits" id="add-credits" required>
                </div>

                <div class="form-group">
                    <label for="add-filiere">Filiere: </label>
                    <select name="add-filiere" id="add-filiere" required>
                        @foreach($filieres as $filiere)
                            <option value="{{$filiere->id}}">{{$filiere->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="add-semester">Semester: </label>
                    <select name="add-semester" id="add-semester" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="close-popup-btn">Cancel</button>
                    <button type="submit" class="btn-submit">Save</button>
                </div>
            </form>
        </x-popup>

        <button id="add-unit-btn" class="open-popup-btn">Add new unit</button>
        <div class="desktop">
            <x-table class="ShowTeachingUnits">

                <form method="GET" action="{{ route('Coordinator.teachingUnits') }}" id="filters-form">
                    <table>
                        <tr>
                            <th>
                                <div class="th-wrapper">
                                    <span>Id</span>
                                    <div class="sort-buttons">
                                        <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => 'asc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt="arrow up"></a>
                                        <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => 'desc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt="arrow down"></a>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <div class="th-wrapper">Name</div>
                            </th>
                            <th>
                                <div class="th-wrapper">Description</div>
                            </th>
                            <th>
                                <div class="th-wrapper">Hours</div>
                            </th>
                            <th>
                                <div class="th-wrapper">
                                    <x-filter-select
                                        name="type"
                                        :options="['all' => 'All', 'CM' => 'CM', 'TD' => 'TD', 'TP' => 'TP']"
                                        label="Type"
                                        default="all"
                                        formId="filters-form"
                                    />
                                </div>
                            </th>
                            <th>
                                <div class="th-wrapper">Credits</div>
                            </th>
                            <th>
                                <div class="th-wrapper">
                                    <x-filter-select
                                        name="filiere"
                                        :options="$filieres->pluck('name', 'id')->prepend('All', 'all')->toArray()"
                                        label="Filiere"
                                        default="all"
                                        formId="filters-form"
                                    />
                                </div>
                            </th>
                            <th>
                                <div class="th-wrapper">
                                    <x-filter-select
                                        name="semester"
                                        :options="['all' => 'All', '1' => '1', '2' => '2']"
                                        label="semester"
                                        default="all"
                                        formId="filters-form"
                                    />
                                </div>
                            </th>
                            <th>
                                <div class="th-wrapper">Status</div>
                            </th>
                            <th>
                                <div class="th-wrapper">
                                    <span>Created At</span>
                                    <div class="sort-buttons">
                                        <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_direction' => 'asc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                        <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_direction' => 'desc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                    </div>


                                </div>
                            </th>
                            <th>
                                <div class="th-wrapper">
                                    <span>Updated At</span>
                                    <div class="sort-buttons">
                                        <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'updated_at', 'sort_direction' => 'asc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                        <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'updated_at', 'sort_direction' => 'desc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <div class="th-wrapper">Actions</div>
                            </th>
                        </tr>

                        @foreach($allTeachingUnits as $unit)
                            <tr>
                                <td>
                                    <div class="td-wrapper">{{ $unit->id }}</div>
                                </td>
                                <td class="text-truncate">{{ $unit->name }}</td>
                                <td class="text-truncate">{{ $unit->description }}</td>
                                <td>
                                    <div class="td-wrapper">{{ $unit->hours }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{ $unit->type }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{ $unit->credits }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{ $unit->filiere->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{ $unit->semester }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">
                                            <span class="chip" data-status="<?php echo e($unit->computedStatus); ?>">
                                                <?php echo e($unit->computedStatus); ?>
                                            </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{ $unit->created_at }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">{{ $unit->updated_at }}</div>
                                </td>
                                <td>
                                    @if($unit->computedStatus == 'assigned' && $unit->computedVacataire)
                                        <div class="td-wrapper">
                                            <a href="{{ route('Coordinator.ReAssignedTeachingUnit', ['id' => $unit->id]) }}"
                                               class="Re-Assign-btn">
                                                <x-svg-icon src="svg/re-assign-paper-icon.svg" width="1.75em"
                                                            stroke="var(--color-warning)"/>
                                            </a>
                                            <a class="Delete-Assign-btn">
                                                <x-svg-icon src="svg/remove-paper-icon.svg" width="1.75em"
                                                            stroke="var(--color-danger)"/>
                                            </a>
                                        </div>
                                    @elseif($unit->computedStatus == 'unassigned')
                                        <div class="td-wrapper">
                                            <a href="{{ route('Coordinator.AssignedTeachingUnit', ['id' => $unit->id]) }}"
                                               class="Assign-btn">
                                                <x-svg-icon src="svg/add-paper-icon.svg" width="1.75em"
                                                            stroke="var(--color-primary)"/>
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </form>
            </x-table>
        </div>

        <div class="mobile">
            <div class="cards-grid">
                @foreach($allTeachingUnits as $unit)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-id">#{{ $unit->id }}</div>
                            <span class="chip" data-status="{{$unit->computedStatus}}">
                                    {{$unit->computedStatus}}
                            </span>
                        </div>

                        <div class="card-body">
                            <div class="info-row">
                                <span class="label">Name:</span>
                                <span class="value">{{ $unit->name }}</span>
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
                                <span class="label">Filiere:</span>
                                <span class="value">{{ $unit->filiere->name ?? 'N/A' }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Type:</span>
                                <span class="value">{{ $unit->type }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Created:</span>
                                <span class="value">{{ \Carbon\Carbon::parse($unit->created_at)->format('Y-m-d H:i') }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Updated:</span>
                                <span class="value">{{ \Carbon\Carbon::parse($unit->updated_at)->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="icons-wrapper flex">
                                @if($unit->computedStatus == 'assigned' && $unit->computedVacataire)
                                    <a href="{{ route('Coordinator.ReAssignedTeachingUnit', ['id' => $unit->id]) }}" class="Re-Assign-btn">
                                        <x-svg-icon src="svg/re-assign-paper-icon.svg" width="1.75em"
                                                    stroke="var(--color-warning)"/>
                                    </a>
                                    <a class="Delete-Assign-btn">
                                        <x-svg-icon src="svg/remove-paper-icon.svg" width="1.75em"
                                                    stroke="var(--color-danger)"/>
                                    </a>
                                @elseif($unit->computedStatus == 'unassigned')
                                    <a href="{{ route('Coordinator.AssignedTeachingUnit', ['id' => $unit->id]) }}" class="Assign-btn">
                                        <x-svg-icon src="svg/add-paper-icon.svg" width="1.75em"
                                                    stroke="var(--color-primary)"/>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if ($allTeachingUnits->hasPages())
            <div class="pagination">
                <a href="{{ $allTeachingUnits->previousPageUrl() }}" class="prev-btn {{ $allTeachingUnits->onFirstPage() ? 'disabled' : '' }}">← previous</a>
                <span class="page-info">{{ $allTeachingUnits->currentPage() }} | {{ $allTeachingUnits->lastPage() }}</span>
                <a href="{{ $allTeachingUnits->nextPageUrl() }}" class="next-btn {{ $allTeachingUnits->hasMorePages() ? '' : 'disabled' }}">next →</a>
            </div>
        @endif

        <div class="modal-overlay" id="modal-overlay" style="display: none">
            <div class="Edit-Teaching-Unite" style="display: none;">
                <form method="POST" action="{{ route('Coordinator.EditUnit')}}" id="editUnitForm">
                    @csrf
                    <h1 id="Unite-Title"></h1>
                    <input type="text" name="UnitID" id="UnitID" style="display: none">

                    <div class="unit-info">
                        <label for="edit-name">Name: </label>
                        <span id="unit-name"></span>
                        <input type="text" name="name" id="edit-name">
                    </div>

                    <div class="unit-info">
                        <label for="edit-description">Description: </label>
                        <span id="unit-description"></span>
                        <textarea name="description" id="edit-description"></textarea>
                    </div>

                    <div class="unit-info">
                        <label for="edit-hours">Hours: </label>
                        <span id="unit-hours"></span>
                        <input type="number" name="hours" id="edit-hours">
                    </div>

                    <div class="unit-info">
                        <label for="edit-type">Type: </label>
                        <span id="unit-type">type</span>
                        <div id="edit-type">
                            <input type="radio" name="type" id="cm" value="CM">
                            <label for="cm">CM</label>

                            <input type="radio" name="type" id="td" value="TD">
                            <label for="td">TD</label>

                            <input type="radio" name="type" id="tp" value="TP">
                            <label for="tp">TP</label>
                        </div>
                    </div>

                    <div class="unit-info">
                        <label for="edit-credits">Credits: </label>
                        <span id="unit-credits"></span>
                        <input type="number" name="credits" id="edit-credits">
                    </div>

                    <div class="unit-info">
                        <label for="edit-filiere'">filiere: </label>
                        <span id="unit-filiere"></span>
                        <input type="text" name="filiere" id="edit-filiere">
                    </div>

                    <div class="unit-info">
                        <label for="edit-semester">Semester: </label>
                        <span id="unit-semester"></span>
                        <input type="text" name="semester" id="edit-semester">
                    </div>

                    <div class="unit-info" id="password-confirmation" style="display: none">
                        <label for="password-confirmation">Enter Your Password For Confirmation : </label>
                        <input type="password" name="password" id="password">
                    </div>

                    <div>
                        <button type="button" id="Edit-Unit-Cancel">Cancel</button>
                        <button type="button" id="Edit-Unit">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
