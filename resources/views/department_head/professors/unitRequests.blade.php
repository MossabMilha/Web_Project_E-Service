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
        <th>{{$unit_request->professor_id}}</th>
        <th>{{$unit_request->unit_id}}</th>
        <th>{{$unit_request->status}}</th>
        <th>{{$unit_request->semester}}</th>
        <th>{{$unit_request->academic_year}}</th>
        <th>{{$unit_request->requested_at}}</th>
        <th>{{$unit_request->reviewed_at}}</th>
        <th>{{$unit_request->reviewed_by}}</th>
    </tr>
</table>
</body>
</html>
