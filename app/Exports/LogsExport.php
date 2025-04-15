<?php

namespace App\Exports;

use App\Models\Log;
use App\Models\LogModel;
use Illuminate\Contracts\Support\Responsable;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
class LogsExport implements FromCollection
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = LogModel::with('user');

        // Filter by role
        if ($this->request->filled('role')) {
            $query->whereHas('user', function ($q) {
                $q->where('role', $this->request->role);
            });
        }

        // Sort
        if ($this->request->filled('sort_by') && $this->request->filled('sort_order')) {
            $query->orderBy($this->request->sort_by, $this->request->sort_order);
        }

        $logs = $query->get();

        // Return only selected fields
        return $logs->map(function ($log) {
            return [
                'ID' => $log->id,
                'User Role' => $log->user->role ?? '',
                'User Name' => $log->user->name ?? '',
                'Action' => $log->action,
                'Description' => $log->description,
                'Created At' => $log->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'User Role',
            'User Name',
            'Action',
            'Description',
            'Created At',
        ];
    }
}
