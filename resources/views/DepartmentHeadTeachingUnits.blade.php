<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/DepartmentHead/TeachingUnits.css'])
    <title>Teaching Units</title>
</head>
<body>
<div class="table-container">
    <table>
        <tr>
            <th>name</th>
            <th>description</th>
            <th>hours</th>
            <th>type</th>
            <th>credits</th>
            <th>semester</th>
            <th>filiere_id</th>
            <th>filiere_name</th>
            <th>Actions</th>
        </tr>
        @foreach($units as $unit)
            <tr>
                <td>{{ $unit->name }}</td>
                <td>{{ $unit->description }}</td>
                <td>{{ $unit->hours }}</td>
                <td>{{ $unit->type }}</td>
                <td>{{ $unit->credits }}</td>
                <td>{{ $unit->semester }}</td>
                <td>{{ $unit->filiere_id }}</td>
                <td>{{ $unit->filiere->name }}</td>
                <td>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/>
                        </svg>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
