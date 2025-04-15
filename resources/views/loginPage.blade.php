<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/login.css', 'resources/css/app.css'])
    <title>Login</title>
</head>
<body>
<div class="login-container">
    <div class="img-container">
        <img src="{{asset("svg/e-service-logo-1.svg")}}" alt="">
    </div>
    <div class="info-container">
        <h2 class="title">Login</h2>
        @if ($errors->any())
            <div id="errorMessage" class="error-label">
                @foreach ($errors->all() as $error)
                    <p>&#9888; {{ $error }}</p>
                @endforeach
            </div>
            <script>
                window.onload = function () {
                    document.getElementById("errorMessage").classList.add("show");
                };
            </script>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p class="copyright">Copyright © 2025 - All rights reserved</p>
    </div>
</div>
</body>
</html>
