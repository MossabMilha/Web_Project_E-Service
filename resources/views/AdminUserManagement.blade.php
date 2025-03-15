
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
        <form method="GET" action="{{route('UserManagement.search')}}">
            <input type="text" id="search" name="search" placeholder="Search">
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
            <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}" alt="Search Icon"></button>
        </form>
        <button class="add-btn">+ Add New User</button>
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
                    <td>{{ $user->specialization }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                        <a href="{{ route('UserManagement.user', $user->id) }}">Edit</a>
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
</div>
</body>
</html>
