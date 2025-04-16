<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    @vite([
    // css files
        'resources/css/app.css',
        'resources/css/components/nav.css',
    // js files
        'resources/js/app.js'
        ])

    <title>{{ $title ?? 'E-Service' }}</title>

    {{-- Optional extra head content --}}
    {{$head ?? '' }}
</head>
<body class="">

    {{-- Page Content --}}
    {{ $slot }}

</body>
</html>
