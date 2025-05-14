<x-layout title="Edit User">

    <x-slot:head>
        @vite([
        'resources/js/AdminUserInfo.js',
        'resources/css/AdminUserInfo.css',
        'resources/js/components/user-role-styling.js'
        ])
    </x-slot:head>

    <x-nav/>

    <!-- Personal-Information -->
    <div class="main-container">
        <div class="edit-user-form">
            <h1>Personal Information</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="user-details-section">

                <!-- Display User Information -->
                <form id="user-info-form" action="{{ route('UserManagement.editUser', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <span id="user-id" style="display: none;">{{$user->id}}</span>

                    <div class="info-item">
                        <label for="name">Name:</label>
                        <span id="user-name">{{$user->name}}</span>
                        <input type="text" id="edit-name" name="name" value="{{ old('name', $user->name) }}"
                               style="display:none;"
                               class="@error('name') is-invalid @enderror">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-item">
                        <label for="phone">Phone Number:</label>
                        <span id="user-phone">{{$user->phone}}</span>
                        <input type="text" id="edit-phone" name="phone" value="{{ old('phone', $user->phone) }}"
                               style="display:none;"
                               class="@error('phone') is-invalid @enderror">
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-item">
                        <label for="email">Email:</label>
                        <span id="user-email">{{$user->email}}</span>
                        <input type="email" id="edit-email" name="email" value="{{ old('email', $user->email) }}"
                               style="display:none;"
                               class="@error('email') is-invalid @enderror">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-item">
                        <label for="specialization">Specialization:</label>
                        <span id="user-specialization">{{$user->specialization}}</span>
                        <input type="text" id="edit-specialization" name="specialization"
                               value="{{ old('specialization', $user->specialization) }}"
                               style="display:none;" class="@error('specialization') is-invalid @enderror">
                        @error('specialization')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-item" id="role-container">
                        <label for="role">Role:</label>
                        <span id="user-role" class="role">{{$user->role}}</span>
                        <select id="edit-role" name="role" style="display:none;" required
                                class="@error('role') is-invalid @enderror">
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

                    <div class="btns-wrapper">
                        <!-- Button to trigger edit mode -->
                        <button id="edit-user-btn" type="button" onclick="toggleEditMode()">Edit</button>

                        <!-- Save Changes Button -->
                        <button id="save-changes" type="submit" style="display:none;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
