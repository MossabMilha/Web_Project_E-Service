<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('UserManagement.adduserDB') }}" method="post">
        @csrf
        <h1>Personal Information</h1>
        <label for="fname">Full Name: </label><input type="text" id="fname" name="fname" required><br><br>
        <label for="email">Email: </label><input type="email" id="email" name="email" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="" disabled selected>Select a role</option>
            <option value="admin">Admin</option>
            <option value="department_head">Department Head</option>
            <option value="coordinator">Coordinator</option>
            <option value="professor">Professor</option>
            <option value="vacataire">Vacataire</option>
        </select>
        <br><br>

        <label for="specialization">Specialization: </label><input type="text" id="specialization" name="specialization"><br><br>

        <input type="submit" value="Submit">
    </form>

</body>
</html>
