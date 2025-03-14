
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
    table, th, td {
        border: 1px solid black;
    }
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 150px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 10px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropbtn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
    }

    .dropbtn:hover {
        background-color: #0056b3;
    }
</style>

<div>
    <button>Add New User </button>
    <form method="GET" action="{{route('UserManagement.search')}}">
        <input type="text" id="search" name="search" placeholder="Search">
        <div class="dropdown">
            <button id="OptionButton" class="dropbtn" value="Option 1" onclick="toggleDropdown()">Select an Option</button>
            <div class="dropdown-content">
                <a href="#" onclick="selectOption('id')">id</a>
                <a href="#" onclick="selectOption('full name')">full name</a>
                <a href="#" onclick="selectOption('email')">email</a>
                <a href="#" onclick="selectOption('role')">role</a>
                <a href="#" onclick="selectOption('specialization')">specialization</a>
            </div>
        </div>
        <input type="hidden" id="selectedOption" name="option" value="{{ request('option', 'id') }}">
        <button type="submit">Search</button>
    </form>
</div>
<div>
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
                <td>{{ $user->role }}</td>
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
</body>
</html>
