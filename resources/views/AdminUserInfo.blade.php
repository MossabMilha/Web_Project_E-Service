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
    <!-- Personal-Information -->
    <div class="Personal-Information">
        <h1>Personal Information</h1>
        <div class="user-details-section">
            <!-- Button to trigger edit mode -->
            <button id="edit-user-btn" type="button" onclick="toggleEditMode()">Edit</button>

            <!-- Display User Information -->
            <form id="user-info-form" action="{{ route('UserManagement.editUser', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <span id="user-id" style="display: none;">{{$user->id}}</span>

                <div class="info-item">
                    <label for="name">Name:</label>
                    <span id="user-name">{{$user->name}}</span>
                    <input type="text" id="edit-name" name="name" value="{{ old('name', $user->name) }}" style="display:none;"
                           class="@error('name') is-invalid @enderror">
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-item">
                    <label for="phone">Phone Number:</label>
                    <span id="user-phone">{{$user->phone}}</span>
                    <input type="text" id="edit-phone" name="phone" value="{{ old('phone', $user->phone) }}" style="display:none;"
                           class="@error('phone') is-invalid @enderror">
                    @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-item">
                    <label for="email">Email:</label>
                    <span id="user-email">{{$user->email}}</span>
                    <input type="email" id="edit-email" name="email" value="{{ old('email', $user->email) }}" style="display:none;"
                           class="@error('email') is-invalid @enderror">
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-item">
                    <label for="specialization">Specialization:</label>
                    <span id="user-specialization">{{$user->specialization}}</span>
                    <input type="text" id="edit-specialization" name="specialization" value="{{ old('specialization', $user->specialization) }}"
                           style="display:none;" class="@error('specialization') is-invalid @enderror">
                    @error('specialization')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-item">
                    <label for="role">Role:</label>
                    <span id="user-role">{{$user->role}}</span>
                    <select id="edit-role" name="role" style="display:none;" required class="@error('role') is-invalid @enderror">
                        <option value="{{$user->role}}" selected>{{$user->role}}</option>
                        @php
                            $roles = ['admin', 'department_head', 'coordinator', 'professor', 'vacataire'];
                            $roles = array_diff($roles, [$user->role]);
                        @endphp
                        @foreach($roles as  $role)
                            <option value="{{$role}}">{{$role}}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Save Changes Button -->
                <button id="save-changes" type="submit" style="display:none;">Save Changes</button>

            </form>
        </div>
    </div>

</body>
</html>
