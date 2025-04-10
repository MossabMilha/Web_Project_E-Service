@php use App\Models\User; @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/Coordinator/AssignedTeachingUnit.js'])
    <title>Document</title>
</head>
<body>
<h1>Information About The Unit</h1>
    <table>
        <tr>
            <th>UnitsId</th>
            <td>{{$unit->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{$unit->name }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{$unit->description }}</td>
        </tr>
        <tr>
            <th>hours</th>
            <td>{{$unit->hours }}</td>
        </tr>
        <tr>
            <th>type</th>
            <td>{{$unit->type }}</td>
        </tr>
        <tr>
            <th>credits</th>
            <td>{{$unit->credits }}</td>
        </tr>
        <tr>
            <th>filliere</th>
            <td>{{$unit->filiere_id }}</td>
        </tr>
        <tr>
            <th>semester</th>
            <td>{{$unit->semester }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{$unit->assignmentStatus()}}</td>
        </tr>
        <tr>
            <th>Units Created At</th>
            <td>{{ $unit->created_at }}</td>
        </tr>
    </table>
    <h1> Available Vacataire</h1>
    <select name="vacataire" id="vacataire">
        <option value="" selected disabled>Choose Vacataire</option>
        @foreach($vacataires as $vacataire)
            <option value="{{ $vacataire->id }}">{{ $vacataire->name }}</option>
        @endforeach
    </select>
    <table id="vacataire-info" style="display: none;">
        <tr>
            <th>User Id</th>
            <td id="user-id"></td>
        </tr>
        <tr>
            <th>Name</th>
            <td id="name"></td>
        </tr>
        <tr>
            <th>Email</th>
            <td id="email"></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td id="phone"></td>
        </tr>
        <tr>
            <th>Role</th>
            <td id="role"></td>
        </tr>
        <tr>
            <th>Specialization</th>
            <td id="specialization"></td>
        </tr>
        <form method="POST" action="{{ route('Coordinator.AssignedTeachingUnitDB') }}">
            @csrf

            <input type="hidden" name="professor_id" id="selected-vacataire-id">


            <input type="hidden" name="unit_id" value="{{ $unit->id }}">

            <tr>
                <th>Password (Your Password)</th>
                <td><input type="password" name="password" required></td>
            </tr>

            <tr>
                <th colspan="2"><button type="submit">Assign The Vacataire To Unit</button></th>
            </tr>
        </form>


        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </table>
</body>
</html>
