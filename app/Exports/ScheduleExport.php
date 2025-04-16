<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Schedule;

class ScheduleExport implements FromCollection
{
    protected $filiereId, $semester;

    public function __construct($filiereId, $semester)
    {
        $this->filiereId = $filiereId;
        $this->semester = $semester;
    }

    public function collection()
    {
        return Schedule::with(['teachingUnit', 'enseignant'])
            ->where('filiere_id', $this->filiereId)
            ->where('semestre', $this->semester)
            ->get()
            ->map(function ($item) {
                return [
                    'Teaching Unit' => $item->teachingUnit->name ?? '',
                    'Teacher' => $item->enseignant->name ?? '',
                    'Room' => $item->salle,
                    'Day' => $item->jour,
                    'Time Slot' => $item->time_slot,
                ];
            });
    }

    public function headings(): array
    {
        return ['Teaching Unit', 'Teacher', 'Room', 'Day', 'Time Slot'];
    }
}
