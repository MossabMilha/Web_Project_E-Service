@php use App\Models\Department; @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/AdminUserInfo.js', 'resources/css/AdminUserInfo.css'])
    <title>Document</title>
</head>
    <body>

    <style>
        body{
            background: grey;
        }
    </style>
    <h1>Personnal Information</h1>
    <div class="user-details-section">
        <!-- Button to trigger edit mode -->
        <button id="edit-user-btn" onclick="toggleEditMode()">Edit</button>

        <!-- Display User Information -->
        <form id="user-info-form" action="{{ route('UserManagement.editUser', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <span id="user-id" style="display: none;">{{$user->id}}</span>

            <div class="info-item">
                <label for="name">Name:</label>
                <span id="user-name">{{$user->name}}</span>
                <input type="text" id="edit-name" name="name" value="{{$user->name}}" style="display:none;">
            </div>

            <div class="info-item">
                <label for="email">Email:</label>
                <span id="user-email">{{$user->email}}</span>
                <input type="email" id="edit-email" name="email" value="{{$user->email}}" style="display:none;">
            </div>

            <div class="info-item">
                <label for="specialization">Specialization:</label>
                <span id="user-specialization">{{$user->specialization}}</span>
                <input type="text" id="edit-specialization" name="specialization" value="{{$user->specialization}}" style="display:none;">
            </div>

            <div class="info-item">
                <label for="role">Role:</label>
                <span id="user-role">{{$user->role}}</span>
                <select id="edit-role" name="role" style="display:none;" required>
                    <option value="{{$user->role}}" selected>{{$user->role}}</option>
                    @php
                        $roles = ['admin', 'department_head', 'coordinator', 'professor', 'vacataire'];
                        $roles = array_diff($roles, [$user->role]);
                    @endphp
                    @foreach($roles as  $role)
                        <option value="{{$role}}">{{$role}}</option>
                    @endforeach
                </select>
            </div>

            <button id="save-changes" style="display:none;" onclick="submit_function(event)">Save Changes</button>
        </form>
    </div>




    <!-- Display Teaching Unit Information -->
    <div id="Teaching-Unit-Information">
        <h1>Teching Unit Information</h1>
        @if($user->role == "professor" || $user->role == "vacataire" )
            @php
                $assigenedCourses = $user->assignments ?? [];
            @endphp
            <button class="add-btn" onclick="openModal()">+ Add Assignment</button>
            <table>
                <tr>
                    <th>name</th>
                    <th>Description</th>
                    <th>Departement id</th>
                    <th>hours</th>
                    <th>credits</th>
                    <th>semester</th>
                    <th>status</th>
                    <th>Edit</th>
                </tr>
                @if($assigenedCourses->isNotEmpty())

                    @foreach($assigenedCourses as $course)
                        @php
                            $information = $course->teachingUnit;
                            $department = $information->department;
                        @endphp

                        <tr>
                            <td>{{$information->name}}</td>
                            <td>{{$information->description}}</td>
                            <td>{{$department->name}}</td>
                            <td>{{$information->hours}}</td>
                            <td>{{$information->credits}}</td>
                            <td>{{$information->semester}}</td>
                            <td>{{$course->status}}</td>
                            <td>

                                <form method="POST" action="{{route('UserManagement.deleteAssignment', $course->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="add-btn" type="submit">+ Delete Assignement</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">No Assignments</td>
                    </tr>
                @endif
            </table>
        @endif
        <div id="addAssignmentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Add Assignment</h2>
                <form method="POST" action="{{route('UserManagement.addAssignment')}}">
                    @csrf
                    <label for="units">Teaching units:</label>

                    <input type="hidden" name="professor_id" value="{{ $user->id }}">

                    <select id="units" name="unit_id" required>
                        <option value="" disabled selected>Select Teaching Unit</option>
                        @php $unassignedUnits = \App\Models\TeachingUnit::whereDoesntHave('assignments')->get();@endphp
                        @foreach($unassignedUnits as $unit)
                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                    </select>

                    <button type="submit">Add Assignment</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
