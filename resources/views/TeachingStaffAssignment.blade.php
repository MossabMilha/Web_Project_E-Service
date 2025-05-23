<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<h1>Hello I am {{$user->name}}</h1>


<div id="Teaching-Unit-Information">
    <h1>Pending Information</h1>
    @php
        $assignments = $user->assignments ?? [];
    @endphp
    <table>
        <tr>
            <th>name</th>
            <th>Description</th>
            <th>Departement id</th>
            <th>hours</th>
            <th>credits</th>
            <th>semester</th>
        </tr>
            @foreach($assignments as $assignment)
{{--                @if($assignment->status == "pending")--}}
                    @php
                        $unit = $assignment->teachingUnit;
                        $department = $unit->filiere->department;
                    @endphp
                    <tr>
                        <td>{{$unit->name}}</td>
                        <td>{{$unit->description}}</td>
                        <td>{{$department->name}}</td>
                        <td>{{$unit->hours}}</td>
                        <td>{{$unit->credits}}</td>
                        <td>{{$unit->semester}}</td>
                        <td>{{$unit->status}}</td>
                    </tr>
{{--                @endif--}}
            @endforeach
{{--        @else--}}
{{--            <tr>--}}
{{--                <td colspan="8">No Pending Assignments</td>--}}
{{--            </tr>--}}
{{--        @endif--}}
    </table>
</div>


</body>
</html>
