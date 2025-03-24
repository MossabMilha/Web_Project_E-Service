@php use App\Models\Department; @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/AdminUserInfo.js', 'resources/css/AdminUserInfo.css'])
    <title>Document</title>
</head>
<style>
    body{
        background: grey;
    }
</style>
    <body>
    <h1>Personal Information</h1>
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

</body>
</html>
