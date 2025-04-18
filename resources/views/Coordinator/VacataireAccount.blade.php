
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
        <form class="add-user-form" method="GET" action="{{ route('VacataireAccount.addVacataire') }}">
            <button class="add-btn" type="submit">+ Add New User</button>
        </form>
        <form method="GET" action="{{ route('export.users') }}">

            <input type="hidden" name="role" value="Vacataire">
            <button type="submit">Export All Vacataire Users</button>
        </form>
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
                            <a href="{{ route('VacataireAccount.user',['id' => $user->id]) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/>
                                </svg>
                            </a>
                            <button onclick="document.getElementById('delete-user').style.display='block'; document.getElementById('user_id').value = {{$user->id}};">Delete user</button>
                            <a href="{{ route('export.users', ['id' => $user->id]) }}">Export</a>

                        </td>
                    </tr>
                @endforeach
            </table>
            <form id="delete-user" style="display:none;" method="POST" action="{{ route('VacataireAccount.deleteVacataire') }}">
                @csrf
                @method('DELETE')
                <h3>Enter your password to confirm deletion:</h3>
                <label>Password : </label><input type="password" name="password" placeholder="Password" required><br>
                <input type="hidden" name="user_id" id="user_id" value="">
                <button type="submit">Confirm Delete</button>
            </form>
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
    </div>
</body>
</html>
