<form action="{{ route('TeachingUnits.assignDB', $unit->id) }}" method="post">
    @csrf
    <label>{{$current_prof->name}}</label>
    <span>------></span>
    <label>Professor name:</label>
    <select name="prof_id">
        @foreach ($profs as $prof)
            <option value="{{ $prof->id }}">{{ $prof->name }}</option>
        @endforeach
    </select>
    <br>
    <input type="submit" value="Submit">
    <a href="{{route('TeachingUnits')}}">Home</a>
</form>
