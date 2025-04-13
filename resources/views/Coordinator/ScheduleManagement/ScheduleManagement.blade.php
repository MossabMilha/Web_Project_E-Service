<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/js/Coordinator/ScheduleManagement/ScheduleManagement.js'])
    <title>Document</title>
</head>
<body>
    <h1>Please Select One Of Your filliere</h1>
    <select id="filiereSelect" name="filiere_id" required>
        <option value="" disabled selected>Select a filière</option>
        @foreach($filieres as $filiere)
            <option value="{{ $filiere->id }}" data-name="{{ $filiere->name }}">{{ $filiere->name }}</option>
        @endforeach
    </select>

    <form method="POST" id="form" action="" style="display: none">
        @csrf
        <input type="hidden" name="filiere_id" id="filiere_id">
        <button type="submit">Continue</button>
    </form>

</body>
</html>
