<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Document</title>
</head>
<body>
<section class="info-section border-2 border-blue-400 mb-1.5">
    <div class="flex items-center gap-3">
        <img width="60px" height="60px" src="{{asset('png/profile-img.jpg')}}" alt="prof-img">
        <h1 class="text-2xl flex items-center">{{$professor->name}}</h1>
        <span class="border-2 border-gray-300 rounded-2xl p-2 text-xs"><strong>{{$professor->role}}</strong></span>
        <h2>{{$professor->specialization}}</h2>
    </div>
    <div>
        <ul>
            <li>
                <label>Email:</label>
                <label>{{$professor->email}}</label>
            </li>
            <li>
                <label>Phone:</label>
                <label>{{$professor->phone}}</label>
            </li>
        </ul>
    </div>
</section>

<section class="border-2 border-blue-400">
    {{--    <img src="" alt="Unit IMG">--}}
    {{--    <div>title-type</div>--}}
    {{--    <div>↗</div>--}}
    @php
        $assignments = $professor->assignments ?? [];
    @endphp
    <table>
        <tr>
            <th>name</th>
            <th>Description</th>
            <th>Departement id</th>
            <th>hours</th>
            <th>credits</th>
            <th>semester</th>
            <th>status</th>
            <th>Edit</th>
        </tr>
        @if($assignments->isNotEmpty())
            @foreach($assignments as $assignment)
                @if($assignment->status == "pending")
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
                        <td>
{{--                            <a href="{{route(unit)}}"></a>--}}
                        </td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="8">No Pending Assignments</td>
            </tr>
        @endif
    </table>
</section>

</body>
</html>
