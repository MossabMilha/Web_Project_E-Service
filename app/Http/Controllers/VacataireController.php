<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class VacataireController extends Controller
{
    public function assignedUnit()
    {
        $assignments = Assignment::with('filiere')->where('professor_id', auth()->user()->id)->get();
        return view('/Vacataire/assignedUnit', compact('assignments'));
    }
}
