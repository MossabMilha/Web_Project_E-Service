<div>{{$unit}}</div>
<table>
    <tr>
        <th>id</th>
        <th>filiere_name</th>
        <th>name</th>
        <th>description</th>
        <th>hours</th>
        <th>type</th>
        <th>credits</th>
        <th>semester</th>
        <th>assigned professors</th>
        <th>status</th>
    </tr>
    <tr>
        <td>{{ $unit->id }}</td>
        <td>{{ $unit->filiere->name }}</td>
        <td>{{ $unit->name }}</td>
        <td>{{ $unit->description }}</td>
        <td>{{ $unit->hours }}</td>
        <td>{{ $unit->type }}</td>
        <td>{{ $unit->credits }}</td>
        <td>{{ $unit->semester }}</td>
        <td>
            @if ($unit->assignments->isEmpty())
                {{ 'No profs assigned' }}
            @else
                @foreach ($unit->assignments as $assignment)
                    {{ $assignment->professor->name }}
                @endforeach
            @endif
        </td>

        <td>
            @if ($unit->assignments->isEmpty())
                {{ 'No status available' }}
            @else
                @foreach ($unit->assignments as $assignment)
                    {{ ucfirst($assignment->status) }}
                @endforeach
            @endif
        </td>
    </tr>

</table>
