<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>

    <form method="GET" action="{{ route('logs.sort') }}">
        <button type="submit" formaction="{{ route('logs.export') }}">Export The Current Logs</button>
        <table>
            <thead>
            <tr>
                <th>
                    Log ID
                    <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => 'asc'])) }}">↑</a>
                    <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => 'desc'])) }}">↓</a>
                </th>
                <th>
                    User Role
                    <select name="role" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>admin</option>
                        <option value="department_head" {{ request('role') == 'department_head' ? 'selected' : '' }}>department_head</option>
                        <option value="coordinator" {{ request('role') == 'coordinator' ? 'selected' : '' }}>coordinator</option>
                        <option value="professor" {{ request('role') == 'professor' ? 'selected' : '' }}>professor</option>
                        <option value="vacataire" {{ request('role') == 'vacataire' ? 'selected' : '' }}>vacataire</option>
                    </select>
                </th>
                <th>User Name</th>
                <th>Action</th>
                <th>Description</th>
                <th>
                    Created At
                    <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_order' => 'asc'])) }}">↑</a>
                    <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_order' => 'desc'])) }}">↓</a>
                </th>
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
    </form>
</body>
</html>
