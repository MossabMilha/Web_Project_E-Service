<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--    @vite(['resources/js/Coordinator/ScheduleManagement/ScheduleManagement.js'])--}}
    <title>Document</title>
</head>
<body>
<style>
    table, th, td {
        border: 1px solid black;
    }
</style>
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
    <!-- Display Schedule for Semestre 1 -->
    <h2>📚 Semestre 1</h2>
    @if($semester1Schedules->isNotEmpty())
        <button onclick="window.location='{{ route('coordinator.ScheduleManagementFiliere.export', ['filiere' => $filiere->id, 'semester' => 1]) }}'">
            Exporter l'emploi du temps
        </button>
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

            @foreach ([1, 2, 3, 4] as $timeSlot)
                <tr>
                    <th>
                        @if ($timeSlot == 1)
                            08:30 - 10:30
                        @elseif ($timeSlot == 2)
                            10:30 - 12:30
                        @elseif ($timeSlot == 3)
                            14:30 - 16:30
                        @else
                            16:30 - 18:30
                        @endif
                    </th>

                    @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $day)
                        <td>
                            @php
                                $currentClasses = $semester1Schedules->filter(function ($schedule) use ($day, $timeSlot) {
                                    return $schedule->jour === $day && $schedule->time_slot === $timeSlot;
                                });
                            @endphp

                            @foreach ($currentClasses as $currentClass)
                                <p><strong>{{ $currentClass->teachingUnit->name }}</strong></p>
                                <p>{{ $currentClass->enseignant->name }}</p>
                                <p>{{ $currentClass->salle }}</p>
                                <hr>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    @else
        <p>No schedule available for Semestre 1.</p>
    @endif

    <!-- Display Schedule for Semestre 2 -->
    <h2>📚 Semestre 2</h2>
    @if($semester2Schedules->isNotEmpty())
        <button onclick="window.location='{{ route('coordinator.ScheduleManagementFiliere.export', ['filiere' => $filiere->id, 'semester' => 2]) }}'">
            Exporter l'emploi du temps
        </button>
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

            @foreach ([1, 2, 3, 4] as $timeSlot)
                <tr>
                    <th>
                        @if ($timeSlot == 1)
                            08:30 - 10:30
                        @elseif ($timeSlot == 2)
                            10:30 - 12:30
                        @elseif ($timeSlot == 3)
                            14:30 - 16:30
                        @else
                            16:30 - 18:30
                        @endif
                    </th>

                    @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $day)
                        <td>
                            @php
                                $currentClasses = $semester2Schedules->filter(function ($schedule) use ($day, $timeSlot) {
                                    return $schedule->jour === $day && $schedule->time_slot === $timeSlot;
                                });
                            @endphp

                            @foreach ($currentClasses as $currentClass)
                                <p><strong>{{ $currentClass->teachingUnit->name }}</strong></p>
                                <p>{{ $currentClass->enseignant->name }}</p>
                                <p>{{ $currentClass->salle }}</p>
                                <hr>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    @else
        <p>No schedule available for Semestre 2.</p>
    @endif

</body>
</html>
