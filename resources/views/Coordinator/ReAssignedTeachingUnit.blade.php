<x-layout title="ReAssigned Teaching Unit">

    <x-slot:head>
        @vite([
            'resources/js/Coordinator/ReAssignedTeachingUnit.js',
            'resources/css/Coordinator/AssignedTeachingUnit.css',
            'resources/css/components/chips.css',
            'resources/js/components/chips.js'
        ])
    </x-slot:head>

    <x-nav/>

    <div class="main-container">
        <div class="unit-info-container">
            <div class="vacataire-section">
                <h1>Information About The Unit</h1>
                <table class="info-table">
                    <tr>
                        <th>UnitsId</th>
                        <td>{{$unit->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{$unit->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{$unit->description }}</td>
                    </tr>
                    <tr>
                        <th>hours</th>
                        <td>{{$unit->hours }}</td>
                    </tr>
                    <tr>
                        <th>type</th>
                        <td>{{$unit->type }}</td>
                    </tr>
                    <tr>
                        <th>credits</th>
                        <td>{{$unit->credits }}</td>
                    </tr>
                    <tr>
                        <th>filliere</th>
                        <td>{{$unit->filiere_id }}</td>
                    </tr>
                    <tr>
                        <th>semester</th>
                        <td>{{$unit->semester }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="chip" data-status="<?php echo e($unit->assignmentStatus()); ?>">
                                <?php echo e($unit->assignmentStatus()); ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Units Created At</th>
                        <td>{{ $unit->created_at }}</td>
                    </tr>
                </table>
            </div>

            <div class="vacataire-section">

                <h1> Old-Vacataire</h1>

                <table id="old-vacataire-info" class="info-table">
                    <tr>
                        <th>User Id</th>
                        <td>{{$oldVacataire->id}}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{$oldVacataire->name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$oldVacataire->email}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{$oldVacataire->phone}}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{$oldVacataire->role}}</td>
                    </tr>
                    <tr>
                        <th>Specialization</th>
                        <td>{{$oldVacataire->specialization}}</td>
                    </tr>
                </table>

                <h1> New-Vacataire</h1>

                <select name="vacataire" id="vacataire" class="vacataire-select">
                    <option value="" selected disabled>Choose Vacataire</option>
                    @foreach($vacataires as $vacataire)
                        <option value="{{ $vacataire->id }}">{{ $vacataire->name }}</option>
                    @endforeach
                </select>

                <table id="vacataire-info" class="info-table" style="display: none;">
                    <tr>
                        <th>User Id</th>
                        <td id="user-id"></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td id="name"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="email"></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td id="phone"></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td id="role"></td>
                    </tr>
                    <tr>
                        <th>Specialization</th>
                        <td id="specialization"></td>
                    </tr>

                </table>

                <form method="POST" action="{{ route('Coordinator.ReAssignedTeachingUnitDB') }}" class="assign-form">
                    @csrf
                    <input type="hidden" name="old-professor_id" value="{{ $oldVacataire->id }}">
                    <input type="hidden" name="professor_id" id="selected-vacataire-id">
                    <input type="hidden" name="unit_id" value="{{ $unit->id }}">

                    <div id="password-group" class="form-group" style="display: none;">
                        <label for="password">Password (Your Password)</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    @if ($errors->any())
                        <div style="color: red;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <button type="submit" class="submit-btn">Assign The Vacataire To Unit</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


</x-layout>
