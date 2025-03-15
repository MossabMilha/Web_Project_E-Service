@php use App\Models\Department; @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/AdminUserManagement.js'])
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
            <div class="user-info">
                <div class="info-item">
                    <label for="name">Name:</label>
                    <span id="user-name">{{$user->name}}</span>
                    <input type="text" id="edit-name" value="John Doe" style="display:none;">
                </div>

                <div class="info-item">
                    <label for="email">Email:</label>
                    <span id="user-email">{{$user->email}}</span>
                    <input type="email" id="edit-email" value="johndoe@example.com" style="display:none;">
                </div>

                <div class="info-item">
                    <label for="specialization">Specialization:</label>
                    <span id="user-specialization">{{$user->specialization}}</span>
                    <input type="text" id="edit-specialization" value="Computer Science" style="display:none;">
                </div>

                <div class="info-item">
                    <label for="role">role:</label>
                    <span id="user-role">{{$user->role}}</span>
                    <input type="text" id="edit-role" value="Computer Science" style="display:none;">
                </div>
            </div>

            <!-- Save Changes Button (Initially Hidden) -->
            <button id="save-changes" style="display:none;" onclick="saveUserDetails()">Save Changes</button>
        </div>
        <!-- Save Button -->
        <button id="save-changes" style="display:none;" onclick="saveUserDetails()">Save Changes</button>

        <script>
            function toggleEditMode() {
                // Toggle the edit mode for the whole section
                const isEditing = document.getElementById('edit-name').style.display === 'inline';

                if (isEditing) {
                    // Save mode: Hide input fields, show text, hide Save button
                    document.getElementById('edit-name').style.display = 'none';
                    document.getElementById('edit-email').style.display = 'none';
                    document.getElementById('edit-specialization').style.display = 'none';
                    document.getElementById('user-name').style.display = 'inline';
                    document.getElementById('user-email').style.display = 'inline';
                    document.getElementById('user-specialization').style.display = 'inline';
                    document.getElementById('save-changes').style.display = 'none';
                } else {
                    // Edit mode: Show input fields, hide text, show Save button
                    document.getElementById('edit-name').style.display = 'inline';
                    document.getElementById('edit-email').style.display = 'inline';
                    document.getElementById('edit-specialization').style.display = 'inline';
                    document.getElementById('user-name').style.display = 'none';
                    document.getElementById('user-email').style.display = 'none';
                    document.getElementById('user-specialization').style.display = 'none';
                    document.getElementById('save-changes').style.display = 'inline';
                }
            }

            function saveUserDetails() {
                // Get the new values from the input fields
                let newName = document.getElementById('edit-name').value;
                let newEmail = document.getElementById('edit-email').value;
                let newSpecialization = document.getElementById('edit-specialization').value;

                // Update the displayed values
                document.getElementById('user-name').textContent = newName;
                document.getElementById('user-email').textContent = newEmail;
                document.getElementById('user-specialization').textContent = newSpecialization;

                // Hide input fields and show the updated values
                document.getElementById('edit-name').style.display = 'none';
                document.getElementById('edit-email').style.display = 'none';
                document.getElementById('edit-specialization').style.display = 'none';
                document.getElementById('user-name').style.display = 'inline';
                document.getElementById('user-email').style.display = 'inline';
                document.getElementById('user-specialization').style.display = 'inline';

                // Hide the Save button
                document.getElementById('save-changes').style.display = 'none';


            }
        </script>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <h1>Teching Unit Information</h1>
        @if($user->role == "professor" || $user->role == "vacataire" )
            @php
                $assigenedCourses = $user->assignments ?? [];
            @endphp
                @if(!empty($assigenedCourses))
                    <table>
                        <tr>
                            <th>name</th>
                            <th>Description</th>
                            <th>Departement id</th>
                            <th>hours</th>
                            <th>credits</th>
                            <th>semester</th>
                            <th>status</th>
                        </tr>
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
                            </tr>
                        @endforeach
                    </table>
                @else
                @endif




        @else
            <h1>Bye</h1>
        @endif


</body>
</html>
