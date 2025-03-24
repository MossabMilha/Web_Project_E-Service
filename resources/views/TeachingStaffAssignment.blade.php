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
            $assigenedCourses = $user->assignments ?? [];
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
            @if($assigenedCourses->isNotEmpty())
                @foreach($assigenedCourses as $course)
                    @if($course->status == "pending")
                        @php
                            $information = $course->teachingUnit;
                            $department = $information->department;
                        @endphp
                        <tr>
                            <td>{{$information->name}}</td>
                            <td>{{$information->description}}</td>
                            <td>{{$department->name}}</td>
                            <td>{{$information->hours}}</td>
                            <td>{{$information->credits}}</td>
                            <td>{{$information->semester}}</td>
                            <td>{{$course->status}}</td>
                            <td>
                                <button class="add-btn" type="submit">Approve</button>
                                <button class="add-btn" type="submit">Reject</button>
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
    </div>





</body>
</html>
