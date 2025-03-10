<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
<form action="{{ route('login') }}" method="post">
    @csrf
    <div>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="{{ old('email') }}">

        <?php if (isset($_SESSION['emailError'])): ?>
        <h1><?= htmlspecialchars($_SESSION['emailError']) ?></h1>
            <?php unset($_SESSION['emailError']); ?>
        <?php endif; ?>
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">


        <?php if (isset($_SESSION['passwordError'])): ?>
        <h1><?= htmlspecialchars($_SESSION['passwordError']) ?></h1>
            <?php unset($_SESSION['passwordError']); ?>
        <?php endif; ?>
    </div>


    <?php if (isset($_SESSION['authError'])): ?>
    <h1><?= htmlspecialchars($_SESSION['authError']) ?></h1>
        <?php unset($_SESSION['authError']); ?>
    <?php endif; ?>

    <button type="submit">Login</button>
</form>
</body>
</html>
