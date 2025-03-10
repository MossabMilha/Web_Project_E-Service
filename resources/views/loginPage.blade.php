<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
@if ($errors->any())
    <div style="color: red;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
<form method="POST" action="{{ route('login') }}">
    @csrf
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Login</button>
</form>
</body>
</html>
