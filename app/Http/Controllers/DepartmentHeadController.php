<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\LogModel;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentHeadController extends Controller
{
    public function workloadOverview()
    {
        LogModel::track('view_workload_overview', "Department Head (ID: " . Auth::user()->id . ") viewed workload overview page.");

        $query = DB::table('users as p')
            ->select(
                'p.id as professor_id',
                'p.name',
                'p.role',
                'wp.min_hours as min_hours',
                'wp.max_hours as max_hours',
                DB::raw('COALESCE(SUM(u.hours), 0) as assigned_hours'),
                DB::raw("
            CASE
                WHEN COALESCE(SUM(u.hours), 0) > wp.max_hours THEN 'Overload'
                WHEN COALESCE(SUM(u.hours), 0) < wp.min_hours THEN 'Underload'
                ELSE 'OK'
            END as status
        ")
            )
            ->join('workload_profiles as wp', 'wp.type', '=', 'p.role')
            ->leftJoin('assignments as a', 'a.professor_id', '=', 'p.id')
            ->leftJoin('teaching_units as u', 'u.id', '=', 'a.unit_id')
            ->groupBy('p.id', 'p.name', 'p.role', 'wp.min_hours', 'wp.max_hours');

        $professors = $query->paginate(10)->appends(request()->query());

        return view('department_head.professors.workload', compact('professors'));
    }
}

