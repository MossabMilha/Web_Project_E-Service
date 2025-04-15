<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <h1>Welcome To Your Profile  {{auth()->user()->name}}</h1>
    <section class="user-Information">
        <img src="{{ asset('png/user-icon-big.png') }}" alt="Logo">
        <table>

            <tr>
                <th>Full Name</th>
                <td>{{auth()->user()->name}}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{auth()->user()->email}}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{auth()->user()->phone}}</td>
            </tr>

            <tr>
                <th>Role</th>
                <td>{{auth()->user()->role}}</td>
            </tr>
            <tr>
                <th>Specialization</th>
                <td>
                    @if(auth()->user()->role == 'professor' || auth()->user()->role == 'vacataire')
                        {{auth()->user()->speciality}}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <th>Member Of Since </th>
                <td>{{auth()->user()->created_at}}</td>
            </tr>
            <tr>
                <th colspan="2">
                    @if(auth()->user()->role == 'admin')
                        <button>Edit Profile Information</button>
                    @else
                        <h3>If You Want To Edit Your Information Contact One OF The Admin</h3>
                    @endif
                </th>
            </tr>
        </table>

    </section>

</body>
</html>
