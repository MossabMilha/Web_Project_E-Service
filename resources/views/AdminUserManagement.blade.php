
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/AdminUserManagement.js', 'resources/css/AdminUserManagement.css'])
    <title>Document</title>
</head>
<body>
    <div class="main-container">
        <div class="search-wrapper">
            <form class="search-form" method="GET" action="{{route('UserManagement.search')}}">
                <div class="search-bar">
                    <input type="text" id="search" name="search" placeholder="Search">
                    <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}" alt="Search Icon"></button>
                </div>
                <div class="dropdown">
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
        <div class="table-container">
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
                            <a href="{{ route('UserManagement.user', $user->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/>
                                </svg>
                            </a>
                            <a href="#" onclick="showDeleteUserSection({{ $user->id }}, '{{ $user->name }}')">Delete user</a>

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        @if ($users->hasPages())
            <div class="pagination">
                <a href="{{ $users->previousPageUrl() }}" class="prev-btn {{ $users->onFirstPage() ? 'disabled' : '' }}">< previous</a>
                <span class="page-info">{{ $users->currentPage() }} | {{ $users->lastPage() }}</span>
                <a href="{{ $users->nextPageUrl() }}" class="next-btn {{ $users->hasMorePages() ? '' : 'disabled' }}">next ></a>
            </div>
        @endif
        <div class="delete-user" style="display: none">
            <form method="POST" action="{{ route('UserManagement.deleteUser', ['id' => $user->id]) }}">
                @csrf
                @method('DELETE')

                <label for="password">Enter Password:</label>
                <br>
                <input id="password" name="password" type="password" placeholder="Enter password" required>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <button type="submit">Delete User</button>
                    <button type="button" onclick="hideDeleteUserModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
