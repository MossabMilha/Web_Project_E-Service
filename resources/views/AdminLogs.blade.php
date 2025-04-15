<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Log ID</th>
                <th>user role</th>
                <th>user name</th>
                <th>Action</th>
                <th>Description</th>
                <th>Created At <a>up</a> <a>down</a> </th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->user->role }}</td>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
