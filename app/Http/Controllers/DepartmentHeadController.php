<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TeachingUnit;
use Illuminate\Http\Request;

class DepartmentHeadController extends Controller
{

    public function index()
    {
        // Eager load the 'filiere' relationship to avoid N+1 queries
        $units = TeachingUnit::with('filiere')->get();
        return view('DepartmentHeadTeachingUnits', compact('units'));
    }

}
