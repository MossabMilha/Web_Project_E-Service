<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>{{ $title ?? 'E-Service' }}</title>

    @vite([
    // css files
        'resources/css/app.css',
        'resources/css/components/nav.css',
        'resources/css/components/table.css',
        'resources/css/components/profile-dropdown.css',
        'resources/css/components/NotificationDropdownStyles.css',
    // js files
        'resources/js/app.js',
        'resources/js/components/nav.js',
        'resources/js/components/table.js',
        'resources/js/components/profile-dropdown.js',
        'resources/js/components/NotificationDropdownToggle.js',

        ])

    {{-- Optional extra head content --}}
    {{$head ?? '' }}
</head>
<body>

    {{-- Page Content --}}
    {{ $slot }}

</body>
</html>
