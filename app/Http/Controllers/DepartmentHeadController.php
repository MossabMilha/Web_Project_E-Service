<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentHeadController extends Controller
{
    public function workloadOverview()
    {
        $professors = DB::select("
        SELECT
            p.id AS professor_id,
            p.name,
            p.role,
            wp.min_hours,
            wp.max_hours,
            COALESCE(SUM(u.hours), 0) AS assigned_hours,
            CASE
                WHEN COALESCE(SUM(u.hours), 0) > wp.max_hours THEN 'Overload'
                WHEN COALESCE(SUM(u.hours), 0) < wp.min_hours THEN 'Underload'
                ELSE 'OK'
            END AS status
        FROM users p
        JOIN workload_profiles wp ON wp.type = p.role
        LEFT JOIN assignments a ON a.professor_id = p.id
        LEFT JOIN teaching_units u ON u.id = a.unit_id
        GROUP BY p.id, p.name, p.role, wp.min_hours, wp.max_hours
    ");

        return view('department_head.professors.workload', compact('professors'));
    }
}

