<table>
    <tr>
        <th>
            <div class="th-wrapper">Time/Days</div>
        </th>
        @foreach ([1, 2, 3, 4] as $timeSlot)
            <th>
                <div class="th-wrapper">
                    @switch($timeSlot)
                        @case(1) 08:30 - 10:30 @break
                        @case(2) 10:30 - 12:30 @break
                        @case(3) 14:30 - 16:30 @break
                        @case(4) 16:30 - 18:30 @break
                    @endswitch
                </div>
            </th>
        @endforeach
    </tr>
    @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $day)
        <tr>
            <th>
                <div class="th-wrapper">
                    @switch($day)
                        @case('Lundi') Monday @break
                        @case('Mardi') Tuesday @break
                        @case('Mercredi') Wednesday @break
                        @case('Jeudi') Thursday @break
                        @case('Vendredi') Friday @break
                        @case('Samedi') Saturday @break
                    @endswitch
                </div>
            </th>
            @foreach ([1, 2, 3, 4] as $timeSlot)
                <td>
                    <div class="td-wrapper">
                        @php
                            $currentClasses = $schedules->filter(fn($sch) => $sch->jour === $day && $sch->time_slot === $timeSlot);
                        @endphp
                        @foreach ($currentClasses as $currentClass)
                            <p><strong>{{ $currentClass->teachingUnit->name }}</strong></p>
                            <p>{{ $currentClass->enseignant->name }}</p>
                            <p>{{ $currentClass->salle }}</p>
                        @endforeach
                    </div>
                </td>
            @endforeach
        </tr>
    @endforeach
</table>
