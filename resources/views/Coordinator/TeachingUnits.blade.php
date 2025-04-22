<x-layout>
    <x-slot:head>
    @vite([
        'resources/js/Coordinator/TeachingUnits.js',
        'resources/js/components/filter-select.js',

        'resources/css/Coordinator/TeachingUnits.css',
        'resources/css/components/filter-select.css',

        ])
    </x-slot:head>

    <x-nav/>

    <div class="main-container">
        <div class="Add-modal-overlay" id="Add-modal-overlay" style="display: none;">
            <div class="Add-Teaching-Unite" >
                <form method="POST" action="{{ route('Coordinator.AddUnit') }}">
                    @csrf
                    <h1>Add New Unit</h1>

                    <div class="add-unit-info">
                        <label for="add-name">Name: </label>
                        <input type="text" name="add-name" id="add-name" required>
                    </div>

                    <div class="add-unit-info">
                        <label for="add-description">Description: </label>
                        <textarea name="add-description" id="add-description" required></textarea>
                    </div>

                    <div class="add-unit-info">
                        <label for="add-hours">Hours: </label>
                        <input type="number" name="add-hours" id="add-hours" required>
                    </div>

                    <div class="add-unit-info">
                        <label for="add-type">Type: </label>
                        <div id="add-type">
                            <input type="radio" name="add-type" id="add-cm" value="CM" required>
                            <label for="add-cm">CM</label>

                            <input type="radio" name="add-type" id="add-td" value="TD">
                            <label for="add-td">TD</label>

                            <input type="radio" name="add-type" id="add-tp" value="TP">
                            <label for="add-tp">TP</label>
                        </div>
                    </div>

                    <div class="add-unit-info">
                        <label for="add-credits">Credits: </label>
                        <input type="number" name="add-credits" id="add-credits" required>
                    </div>

                    <div class="add-unit-info">
                        <label for="add-filiere">Filiere: </label>
                        <select name="add-filiere" id="add-filiere" required>
                            @foreach($filieres as $filiere)
                                <option value="{{$filiere->id}}">{{$filiere->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="add-unit-info">
                        <label for="add-semester">Semester: </label>
                        <select name="add-semester" id="add-semester" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>

                    <div>
                        <button type="button" id="add-Unit-Cancel" >Cancel</button>
                        <button type="submit" id="add-Unit">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <x-table class="ShowTeachingUnits">
            <button id="add-unit-btn">Add New Unit</button>

            <form method="GET" action="{{ route('Coordinator.teachingUnits') }}" id="filters-form">
                <table>
                    <tr>
                        <th>
                            <div class="th-wrapper">
                                <span>Id</span>
                                <div class="sort-buttons">
                                    <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => 'asc'])) }}"><img src="{{asset('png/arrow up 2.png')}}"></a>
                                    <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'id', 'sort_direction' => 'desc'])) }}"><img src="{{asset('png/arrow up 2.png')}}"></a>
                                </div>
                            </div>
                        </th>
                        <th><div class="th-wrapper">Name</div></th>
                        <th><div class="th-wrapper">Description</div></th>
                        <th><div class="th-wrapper">Hours</div></th>
                        <th>
                            <x-filter-select
                                name="type"
                                :options="['all' => 'All', 'CM' => 'CM', 'TD' => 'TD', 'TP' => 'TP']"
                                label="Type"
                                default="all"
                                formId="filters-form"
                            />
                        </th>
                        <th><div class="th-wrapper">Credits</div></th>
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
                        <th><div class="th-wrapper">Status</div></th>
                        <th>
                            <div class="th-wrapper">
                                <span>Created At</span>
                                <div class="sort-buttons">
                                    <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_direction' => 'asc'])) }}"><img src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                    <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_direction' => 'desc'])) }}"><img src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                </div>


                            </div>
                        </th>
                        <th>
                            <div class="th-wrapper">
                            <span>Updated At</span>
                                <div class="sort-buttons">
                                    <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'updated_at', 'sort_direction' => 'asc'])) }}"><img src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                    <a href="{{ route('Coordinator.teachingUnits', array_merge(request()->all(), ['sort_by' => 'updated_at', 'sort_direction' => 'desc'])) }}"><img src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                </div>
                            </div>
                        </th>
                        <th><div class="th-wrapper">Actions</div></th>
                    </tr>

                    @foreach($allTeachingUnits as $unit)
                        <tr>
                            <td>{{ $unit->id }}</td>
                            <td class="text-truncate">{{ $unit->name }}</td>
                            <td class="text-truncate">{{ $unit->description }}</td>
                            <td>{{ $unit->hours }}</td>
                            <td>{{ $unit->type }}</td>
                            <td>{{ $unit->credits }}</td>
                            <td>{{ $unit->filiere->name ?? 'N/A' }}</td>
                            <td>{{ $unit->semester }}</td>
                            <td>{{ $unit->assignmentStatus() }}</td>
                            <td>{{ $unit->created_at }}</td>
                            <td>{{ $unit->updated_at }}</td>
                            <td>
                                @if($unit->assignmentStatus() == 'assigned' && $unit->assignedVacataire())
                                    <a href="{{ route('Coordinator.ReAssignedTeachingUnit', ['id' => $unit->id]) }}" class="Re-Assign-btn">
                                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800">
                                            <defs>
                                                <style>
                                                    .b4e30752-d4ee-44ed-af4f-17915f36cc38,.ecdafdf7-088d-4671-a7a8-7e83de742b35{
                                                        fill:none;
                                                        stroke-linecap:round;
                                                        stroke-linejoin:bevel;
                                                    }
                                                    .ecdafdf7-088d-4671-a7a8-7e83de742b35{
                                                        stroke-width:50px;
                                                    }
                                                    .b4e30752-d4ee-44ed-af4f-17915f36cc38{
                                                        stroke-width:30px;
                                                    }
                                                </style>
                                            </defs>
                                            <g id="baf4be44-2e28-4491-bbbf-ad873dbf634f" data-name="ic-actions-add-file">
                                                <path class="ecdafdf7-088d-4671-a7a8-7e83de742b35" d="M495.33,66.67H200a66.66,66.66,0,0,0-66.67,66.66V666.67A66.66,66.66,0,0,0,200,733.33H600a66.66,66.66,0,0,0,66.67-66.66V297.33a31.4,31.4,0,0,0-6-19L522.33,81A33.3,33.3,0,0,0,495.33,66.67Z"/>
                                                <path class="b4e30752-d4ee-44ed-af4f-17915f36cc38" d="M265.67,485a142.4,142.4,0,0,1,235-148l12.59,12.59"/><line class="b4e30752-d4ee-44ed-af4f-17915f36cc38" x1="513.27" y1="349.57" x2="437.76" y2="349.57"/>
                                                <line class="b4e30752-d4ee-44ed-af4f-17915f36cc38" x1="513.27" y1="349.57" x2="513.27" y2="274.06"/>
                                                <path class="b4e30752-d4ee-44ed-af4f-17915f36cc38" d="M534.34,390.39a142.41,142.41,0,0,1-235,148l-12.59-12.58"/>
                                                <line class="b4e30752-d4ee-44ed-af4f-17915f36cc38" x1="286.73" y1="525.77" x2="362.24" y2="525.77"/>
                                                <line class="b4e30752-d4ee-44ed-af4f-17915f36cc38" x1="286.73" y1="525.77" x2="286.73" y2="601.28"/>
                                            </g>
                                        </svg>
                                    </a>
                                    <a class="Delete-Assign-btn">
                                        <svg viewBox="0 0 24 24" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <defs>
                                                    <style>
                                                        .cls-1,.cls-2{
                                                            fill:none;
                                                            stroke-linecap:round;
                                                            stroke-linejoin:bevel;
                                                            stroke-width:1.5px;
                                                        }
                                                        .cls-1{fill-rule:evenodd;}
                                                    </style>
                                                </defs>
                                                <g id="ic-actions-paper-remove">
                                                    <path class="cls-1" d="M14.86,2H6A2,2,0,0,0,4,4V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V8.92a.94.94,0,0,0-.18-.57L15.67,2.43A1,1,0,0,0,14.86,2Z"></path>
                                                    <line class="cls-2" x1="16" y1="13" x2="8" y2="13"></line>
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                @elseif($unit->assignmentStatus() == 'unassigned')
                                    <a href="{{ route('Coordinator.AssignedTeachingUnit', ['id' => $unit->id]) }}" class="Assign-btn">
                                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <defs>
                                                    <style>
                                                        .cls-1,.cls-2{
                                                            fill:none;
                                                            stroke-linecap:round;
                                                            stroke-linejoin:bevel;
                                                            stroke-width:1.5px;
                                                        }
                                                        .cls-2{fill-rule:evenodd;}
                                                    </style>
                                                </defs>
                                                <g id="ic-actions-add-file">
                                                    <line class="cls-1" x1="16" y1="13.13" x2="8" y2="13.13"></line>
                                                    <line class="cls-1" x1="12" y1="17.13" x2="12" y2="9.13"></line>
                                                    <path class="cls-2" d="M14.86,2H6A2,2,0,0,0,4,4V20a2,2,0,0,0,2,2H18a2,2,0,0,0,2-2V8.92a.94.94,0,0,0-.18-.57L15.67,2.43A1,1,0,0,0,14.86,2Z"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </form>

            @if ($allTeachingUnits->hasPages())
                <div class="pagination">
                    <a href="{{ $allTeachingUnits->previousPageUrl() }}" class="prev-btn {{ $allTeachingUnits->onFirstPage() ? 'disabled' : '' }}">← previous</a>
                    <span class="page-info">{{ $allTeachingUnits->currentPage() }} | {{ $allTeachingUnits->lastPage() }}</span>
                    <a href="{{ $allTeachingUnits->nextPageUrl() }}" class="next-btn {{ $allTeachingUnits->hasMorePages() ? '' : 'disabled' }}">next →</a>
                </div>
            @endif
        </x-table>

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
