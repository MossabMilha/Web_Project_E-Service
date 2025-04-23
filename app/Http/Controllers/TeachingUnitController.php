<?php

namespace App\Http\Controllers;

use App\Models\TeachingUnit;

class TeachingUnitController extends Controller
{
    public function index()
    {
        $units = TeachingUnit::with(['filiere', 'assignments.professor'])->paginate(10);
        return view('department-head.teaching-units.index', compact('units'));
    }

    public function search(){

    }
}
