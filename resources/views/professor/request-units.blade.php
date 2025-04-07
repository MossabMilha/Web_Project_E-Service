<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>request units</title>
</head>
<body>
    <form id="units-request-form" action="{{route('professor.units.request.store', $professor->id)}}" method="post">
        @csrf
        <label>prof name: </label>
        <label>{{$professor->name}}</label>
        <br>
        <select id="unit-selector" name="unit_id">
            <option value="0" disabled>select an option</option>
            @foreach($units as $unit)
                @php
                    $units_id_name[$unit->id] = $unit->name;
                @endphp
                <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endforeach
        </select>
        <div id="selected-unit-container"></div>
        <input type="hidden" name="selected_units" id="unitsInput">
        <input type="submit" value="submit">
    </form>
</body>
</html>
