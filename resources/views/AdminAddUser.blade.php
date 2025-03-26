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
    @if ($errors->any())
        <div class="error-messages-holder">
            <div class="error-messages">
                <h1>Invalid Information</h1>
            </div>
        </div>
    @endif
    <form class="add-user-form" action="{{ route('UserManagement.adduserDB') }}" method="post">
        @csrf
        <div class="name-wrapper wrapper">
            <label for="name">Full Name: </label>
            @if($errors->has('name'))
                <p class="error-text">{{ $errors->first('name') }}</p>
            @endif
            <input type="text" id="name" name="name" required>

        </div>

        <div class="email-wrapper wrapper">
            <label for="email">Email: </label>
            @if($errors->has('email'))
                <p class="error-text">{{ $errors->first('email') }}</p>
            @endif
            <input type="email" id="email" name="email" required>

        </div>

        <div class="phone-wrapper wrapper">
            <label for="phone">phone: </label>
            @if($errors->has('phone'))
                <p class="error-text">{{ $errors->first('phone') }}<span>+212-601020304</span></p>
            @endif
            <input type="text" id="phone" name="phone" required>

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
            <label for="specialization">Specialization(Professor/Vacataire): </label>
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
