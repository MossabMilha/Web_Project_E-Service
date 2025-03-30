<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\Professor;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index(){
        $professors = User::all()->where('role', 'professor');
        return view('professors.index', compact('professors'));
    }
    public function show($id){
        $professor = User::find($id);
        return view('Professor/profile', compact('professor'));
    }
    public function assignUnits($id){
        $department_id = DepartmentMember::where('professor_id', $id)->value('department_id');
        $filiere = Filiere::where('department_id', $department_id)->get();

        $professor = User::find($id);
        $units = TeachingUnit::
        whereDoesntHave('assignments')
        ->whereHas('filiere', function($q) use($filiere){
            $q->whereIn('id', $filiere->pluck('id'));
        })
        ->get();

        return view('DepartmentHead/assignUnits', compact('professor', 'units'));
    }

    public function assignUnitsDB(Request $request, $professor_id) {
        // Validate input
        $request->validate([
            'unit_id' => 'required|exists:teaching_units,id', // Ensure the unit exists
        ]);

        $unit_id = $request->input('unit_id');

        // Check if assignment already exists
        $assignment = Assignment::where('professor_id', $professor_id)
            ->where('unit_id', $unit_id)
            ->first();

        if (!$assignment) {
            // Create a new assignment if it does not exist
            Assignment::create([
                'professor_id' => $professor_id,
                'unit_id' => $unit_id,
            ]);
        }

        return redirect()->route('Professors.list')->with('success', 'Unit assigned successfully.');
    }

    public function removeAssign($unit_id, $professor_id)
    {
        $assignment = Assignment::where('unit_id', $unit_id)
            ->where('professor_id', $professor_id)
            ->first();

        if ($assignment) { // Check if assignment exists
            $assignment->delete();
            return redirect()->route('Professors.list')->with('success', 'Unit assignment was deleted successfully.');
        }

        return redirect()->route('Professors.list')->with('error', 'Unit assignment not found.');
    }

}
