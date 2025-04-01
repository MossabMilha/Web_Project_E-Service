<form action="{{route('Professor.assignUnitsDB', $professor->id)}}" method="post">
    @csrf
    <label>prof name: </label>
    <label>{{$professor->name}}</label>
    <br>
    <select name="unit_id">
        @foreach($units as $unit)
            <option value="{{$unit->id}}">{{$unit->name}}</option>
        @endforeach
    </select>
    <input type="submit" value="submit">
</form>
