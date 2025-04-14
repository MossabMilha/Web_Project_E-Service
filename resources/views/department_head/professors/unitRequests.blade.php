<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>units requests</title>
</head>
<body>
    <table>
        <tr>
            <th>professor id</th>
            <th>professor name</th>
            <th>unit id</th>
            <th>unit label</th>
            <th>status</th>
            <th>semester</th>
            <th>academic year</th>
            <th>workload hours</th>
            <th>min required hours</th>
            <th>requested at</th>
            <th>reviewed at</th>
            <th>reviewed by</th>
        </tr>
        @foreach($unit_requests as $unit_request)
        <tr @if($unit_request->underloaded) style="background-color: #ffe5e5;" @endif>
            <td>{{$unit_request->professor_id}}</td>
            <td>{{$unit_request->professor->name}}</td>
            <td>{{$unit_request->unit_id}}</td>
            <td>{{$unit_request->unit->name}}</td>
            <td>{{$unit_request->status}}</td>
            <td>{{$unit_request->semester}}</td>
            <td>{{$unit_request->academic_year}}</td>
            <td>{{$unit_request->assigned_hours}}</td>
            <td>{{$unit_request->min_hours}}</td>
            <td>{{$unit_request->requested_at}}</td>
            <td>{{$unit_request->reviewed_at}}</td>
            <td>
                @if($unit_request->reviewed_by != null)
                    {{$unit_request->reviewed_by}}
                @else
                    not reviewed
                @endif
            </td>
            <td>
                <form action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" name="action" value="approve" class="btn btn-primary">approve</button>
                </form>
            </td>
            <td>
                <form action="{{route('department-head.professors.unit.request.handle', $unit_request->id)}}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" name="action" value="reject" class="btn btn-danger">reject</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
<style>
    body {
        background-color: #cfdcf5;
    }
    table tr > *{
        border: 1px solid #ff4433;
    }
</style>
</html>
