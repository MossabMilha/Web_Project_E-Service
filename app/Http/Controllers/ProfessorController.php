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
        $request->merge([
            'selected_units' => json_decode($request->input('selected_units'), true)
        ]);
        // Validate the input to ensure selected_units_id is an array and contains valid unit IDs
        $request->validate([
            'selected_units' => 'required|array', // Ensure it's an array
            'selected_units.*' => 'exists:teaching_units,id', // Ensure each unit_id exists in the teaching_units table
        ]);

        // Retrieve the selected unit IDs from the request
        $selected_units_ids = $request->input('selected_units');

        // Get all existing assignments for the professor and the selected unit IDs in one query
        $existing_assignments = Assignment::where('professor_id', $professor_id)
            ->whereIn('unit_id', $selected_units_ids)
            ->pluck('unit_id') // Only retrieve the unit_ids that already exist
            ->toArray();

        // Filter out the unit IDs that already have an assignment
        $units_to_assign = array_diff($selected_units_ids, $existing_assignments);

        // If there are any units left to assign (i.e., no existing assignment for those)
        if (count($units_to_assign) > 0) {
            // Prepare an array of assignments for bulk insertion
            $assignments = array_map(function ($unit_id) use ($professor_id) {
                return [
                    'professor_id' => $professor_id,
                    'unit_id' => $unit_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $units_to_assign);

            // Bulk insert the assignments
            Assignment::insert($assignments);
        }

        // Redirect with a success or info message
        if (count($units_to_assign) > 0) {
            return redirect()->route('department-head.professors.index')->with('success', 'Unit(s) assigned successfully!');
        } else {
            return redirect()->route('department-head.professors.index')->with('info', 'The selected unit(s) are already assigned to this professor.');
        }
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
