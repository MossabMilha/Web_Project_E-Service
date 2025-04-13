<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Workload Hours</title>
</head>
<body>
<div class="container">
    <h2>Professors' Workload Hours</h2>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Min Hours</th>
            <th>Max Hours</th>
            <th>Assigned Hours</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($professors as $prof)
            <tr>
                <td>{{ $prof->professor_id }}</td>
                <td>{{ $prof->name }}</td>
                <td>{{ $prof->role }}</td>
                <td>{{ $prof->min_hours }}</td>
                <td>{{ $prof->max_hours }}</td>
                <td>{{ $prof->assigned_hours }}</td>
                <td>
                    @if ($prof->status === 'Overload')
                        <span class="text-danger">{{ $prof->status }}</span>
                    @elseif ($prof->status === 'Underload')
                        <span class="text-warning">{{ $prof->status }}</span>
                    @else
                        <span class="text-success">{{ $prof->status }}</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
<style>
    body {
        background-color: #cfdcf5;
    }
    table tr > *{
        border: 1px solid #001d1e;
    }
    .text-danger{
        color: #ff3232;
    }
    .text-warning{
        color: #b66e1c;
    }
    .text-success{
        color: #139f33;
    }

</style>
</html>
