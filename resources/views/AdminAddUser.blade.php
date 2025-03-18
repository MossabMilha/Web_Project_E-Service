<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/AdminAddUser.js', 'resources/css/AdminAddUser.css'])
    <title>Add User</title>
</head>
<body>
<div class="main-container">
    <h1> Add User Information</h1>
    <form class="add-user-form" action="{{ route('UserManagement.adduserDB') }}" method="post">
        @csrf
        <div class="fname-wrapper wrapper">
            <label for="fname">Full Name: </label>
            <input type="text" id="fname" name="fname" required>
        </div>

        <div class="email-wrapper wrapper">
            <label for="email">Email: </label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="role-wrapper wrapper">
            <label for="role">Role:</label>
            <div class="role-dropdown">
                <div class="selected">Select a role</div>
                <div class="dropdown-options">
                    <!-- options generated automatically-->
                </div>
            </div>
        </div>
        <input type="hidden" name="role" id="selectedRoleInput">

        <div class="spec-wrapper wrapper">
        <label for="specialization">Specialization: </label>
        <input type="text" id="specialization" name="specialization">
        </div>

        <div class="btns-wrapper">
            <a class="back-btn" href="{{asset('/Admin/UserManagement')}}">back</a>
            <input type="submit" value="Submit">
        </div>

    </form>
</div>
</body>
</html>
