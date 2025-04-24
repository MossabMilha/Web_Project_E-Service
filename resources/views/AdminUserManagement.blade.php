<x-layout title="User Management">
    <x-slot:head>
        @vite([
            // css files
            'resources/css/AdminUserManagement.css',
            // js files
            // 'resources/js/components/user-role-styling.js' // TODO: use this instead of AdminUserManagement.js
            'resources/js/AdminUserManagement.js',
        ])
    </x-slot:head>

    <x-nav/>

    {{--  body  --}}
    <div class="main-container">
        <div class="search-wrapper"> {{--  TODO: make a search component that work with dropdown components--}}
            <form class="search-form" method="GET" action="{{route('UserManagement.search')}}">
                <div class="search-bar">
                    <input type="text" id="search" name="search" placeholder="Search">
                    <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}" alt="Search Icon"></button>
                </div>
                <div class="dropdown"> {{--  TODO: make dropdown component dynamic that work with any option--}}
                    <button id="OptionButton" onclick="toggleDropdown()">Select an Option</button>
                    <div class="dropdown-content">
                        <a href="#" onclick="selectOption('id')">id</a>
                        <a href="#" onclick="selectOption('full name')">full name</a>
                        <a href="#" onclick="selectOption('email')">email</a>
                        <a href="#" onclick="selectOption('role')">role</a>
                        <a href="#" onclick="selectOption('specialization')">specialization</a>
                    </div>
                </div>
                <input type="hidden" id="selectedOption" name="option" value="{{ request('option', 'id') }}">
            </form>
            <form class="add-user-form" method="GET" action="{{ route('UserManagement.adduser') }}">
                <button class="add-btn" type="submit">+ Add New User</button>
            </form>
        </div>
        <x-table> {{--TODO: think of a way to make a table component. You can do better :)--}}
            <table>
                <tr>
                    <th>User Id</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Specialisation</th>
                    <th>Account Created At</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><div class="role">{{$user->role}}</div></td>
                        <td>
                            @if($user->specialization == null)
                                N/A
                            @else
                                {{ $user->specialization }}
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                            <div class="icons-wrapper flex">
                                <a href="{{ route('UserManagement.user', $user->id) }}">
                                    <x-svg-icon src="svg/edit-profile-icon.svg" width="32px" stroke="none" fill="var(--color-warning)"/>
                                </a>
                                <a href="#" onclick="showDeleteUserSection({{ $user->id }}, '{{ $user->name }}')">
                                    <x-svg-icon src="svg/delete-profile-icon.svg" fill="var(--color-danger)"/>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        @if ($users->hasPages())
            <div class="pagination">
                <a href="{{ $users->previousPageUrl() }}" class="prev-btn {{ $users->onFirstPage() ? 'disabled' : '' }}">< previous</a>
                <span class="page-info">{{ $users->currentPage() }} | {{ $users->lastPage() }}</span>
                <a href="{{ $users->nextPageUrl() }}" class="next-btn {{ $users->hasMorePages() ? '' : 'disabled' }}">next ></a>
            </div>
        @endif
        </x-table>


        <div class="delete-user-popup popup">
            <form id="deleteForm" method="POST" action="{{ route('UserManagement.deleteUser', ['id' => $user->id]) }}">
                @csrf
                @method('DELETE')
                <img src="{{asset('png/warning.jpg')}}" alt="alert image" class="popup-img-top">
                <div class="content">
                    <p class="delete-message"></p>
                    <div class="password-container">
                        <label for="password">Enter Password:</label>
                        <input id="password" name="password" type="password" placeholder="Password" required>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="button-container">
                    <button type="submit">Delete User</button>
                    <button type="button" onclick="hideDeleteUserModal()">Cancel</button>
                </div>
            </form>
        </div>

    </div>
</x-layout>
