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
        // Cache the department ID lookup
        $departmentId = cache()->remember(
            'department-head-'.Auth::id(),
            now()->addHours(6),
            fn() => Department::where('head_id', Auth::id())->value('id')
        );

        if (!$departmentId) {
            abort(404, 'Department not found');
        }

        // Optimized professors query
        $professors = User::query()
            ->where('role', 'professor')
            ->whereHas('departmentMember', fn($q) => $q->where('department_id', $departmentId))
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        // Optimized units query with proper eager loading
        $units = TeachingUnit::query()
            ->select([
                'id',
                'name',
                'hours',
                'type',
                'credits',
                'semester',
                'filiere_id'
            ])
            ->with([
                'filiere:id,name'
            ])
            ->paginate(10);

        return view('department_head.teaching_units.index', [
            'units' => $units,
            'professors' => $professors
        ]);
    }

    public function search(){

    }
}
