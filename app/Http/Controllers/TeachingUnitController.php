<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeachingUnitController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Cache the department ID lookup for this head
        $departmentId = cache()->remember(
            "department-head-{$userId}",
            now()->addHours(6),
            fn() => Department::where('head_id', $userId)->value('id')
        );

        abort_unless($departmentId, 404, 'Department not found');

        // Retrieve professors only from the relevant department
        $professors = User::select('id', 'name')
            ->where('role', 'professor')
            ->whereHas('departmentMember', fn($q) => $q->where('department_id', $departmentId))
            ->orderBy('name')
            ->get();

        // Teaching units with eager-loaded filiere, and only required columns
        $units = TeachingUnit::with([
            'filiere:id,name'
        ])
            ->select(['id', 'name', 'description', 'hours', 'type', 'credits', 'semester', 'filiere_id'])
            ->paginate(10);

        // Add `status` manually based on latest assignment
        $units->transform(function ($unit) {
            $latest = $unit->assignments->first(); // already ordered desc
            $unit->status = match ($latest?->status) {
                'approved' => 'assigned',
                'pending' => 'pending',
                default => 'unassigned',
            };
            return $unit;
        });


        return view('department_head.teaching_units.index', compact('units', 'professors'));
    }

    public function search(){

    }
}
