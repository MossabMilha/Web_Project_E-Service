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
    <h1>Hello {{auth()->user()->name}}</h1>
    <h1>You are assigned To {{$assignments->count()}} Teaching Unit</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Hours</th>
            <th>credits</th>
            <th>Filliere-Semester</th>
        </tr>
        <tr>
            @foreach($assignments as $assignment)
                <td>{{$assignment->teachingUnit->name}}</td>
                <td>{{$assignment->teachingUnit->description}}</td>
                <td>{{$assignment->teachingUnit->hours}}</td>
                <td>{{$assignment->teachingUnit->credits}}</td>
                <td>{{$assignment->teachingUnit->filiere->name}}-{{$assignment->teachingUnit->semester}}</td>
            @endforeach
        </tr>

    </table>


</body>
</html>
