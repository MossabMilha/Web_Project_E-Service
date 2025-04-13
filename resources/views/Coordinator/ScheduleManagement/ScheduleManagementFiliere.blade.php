<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    @vite(['resources/js/Coordinator/ScheduleManagement/ScheduleManagement.js'])--}}
    <title>Document</title>
</head>
<body>
    <h1>📅 Schedule Management - {{$filiere->name}}</h1>
    <a href="#" onclick="document.getElementById('import-form').style.display='block'">
        Importer un emploi du temps
    </a>
    <div id="import-form" style="display:none; margin-top:20px;">
        <form action="{{ route('coordinator.ScheduleManagementFiliere.import', ['filiere' => $filiere->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="semestre">Choisir le semestre :</label>
            <select name="semestre" required>
                <option value="1">Semestre 1</option>
                <option value="2">Semestre 2</option>
            </select>

            <br><br>

            <label for="file">Fichier Excel :</label>
            <input type="file" name="file" accept=".xlsx,.csv" required>

            <br><br>
            <button type="submit">Importer</button>
        </form>
    </div>
    <table>
        <tr>
            <th>Hours</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
        </tr>
        <tr>
            <th>08:30 - 10:30</th>
        </tr>
        <tr>
            <th>10:30 - 12:30</th>
        </tr>
        <tr>
            <th>14:30 - 16:30</th>
        </tr>
        <tr>
            <th>16:30 - 18:30</th>
        </tr>

    </table>

</body>
</html>
