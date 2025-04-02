<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index(){
        $department_id = 1; // this will be the id of the department that the head belong to
        $professors = User::where('role', 'professor')
            ->whereHas('departmentMember', function ($query) use ($department_id) {
                $query->where('department_id', $department_id);
            })
            ->with('departmentMember')
            ->get();
        $profsWithUnits = [];

        foreach ($professors as $professor) {
            if ($professor) {
                $units = TeachingUnit::
                wherehas('assignments', function ($q) use ($professor) {
                    $q->where('professor_id', $professor->id);})
                    ->with('assignments')
                    ->get();
            } else {
                $units = collect();
//                $assignedUnits = collect();
            }
            $profsWithUnits[] = [
                'professor' => $professor,
                'units' => $units,
            ];
        }

        return view('department-head.professors.index', compact('profsWithUnits'));
    }

    public function assign($id)
    {
        $department_id = DepartmentMember::where('professor_id', $id)->value('department_id');
        $filiere = Filiere::where('department_id', $department_id)->get();

        $professor = User::find($id);
        $units = TeachingUnit::
        whereDoesntHave('assignments')
            ->whereHas('filiere', function($q) use($filiere){
                $q->whereIn('id', $filiere->pluck('id'));
            })
            ->get();

        return view('department-head.professors.assign', compact('professor', 'units'));
    }

    public function storeAssignment(Request $request, $professor_id)
    {
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
        // Redirect with a success message
        return redirect()->route('department-head.professors.index')->with('success', 'unit(s) assigned successfully!');
    }

    public function destroyAssignment($professor_id, $unit_id)
    {
        $assignment = Assignment::where('unit_id', $unit_id)
            ->where('professor_id', $professor_id)
            ->first();

        if ($assignment) { // Check if assignment exists
            $assignment->delete();
            return redirect()->route('department-head.professors.index')->with('success', 'Unit assignment was deleted successfully.');
        }

        return redirect()->route('department-head.professors.index')->with('error', 'Unit assignment not found.');
    }

}
