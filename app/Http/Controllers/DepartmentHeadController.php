<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentHeadController extends Controller
{

    public function index()
    {
        $units = TeachingUnit::with(['filiere', 'assignments.professor'])->paginate(10);;
        return view('DepartmentHead/TeachingUnits', compact('units'));
    }

    public function show($id)
    {
        $unit = TeachingUnit::with('filiere')->find($id);
        return view('DepartmentHead/unit', compact('unit'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $searchOption = $request->input('option', 'id');

        // Start the query with the TeachingUnit model
        $query = TeachingUnit::query();

        // Apply search condition based on searchOption (status or other options)
        if ($searchOption === 'status') {
            // Query units that have assignments with the specified status
            $status = $searchTerm; // Assuming the search term is the status
            $query->whereHas('assignments', function ($q) use ($status) {
                $q->where('status', $status); // Filter by the specified status
            });
        }

        // Apply search condition based on searchTerm for other options
        if ($searchTerm && $searchOption !== 'status') {
            if ($searchOption === 'id') {
                // Search by id, ensure the id is treated as a string for pattern matching
                $query->whereRaw("CAST(id AS CHAR) LIKE ?", ['%' . $searchTerm . '%']);
            } else {
                // Search by other fields (e.g., name or description)
                $query->where($searchOption, 'like', '%' . $searchTerm . '%');
            }
        }

        // Execute the query and paginate the results
        $units = $query->paginate(10)->appends(request()->query());

        // Return the view with the search results
        return view('DepartmentHead/TeachingUnits', compact('units'));
    }

    public function assign($id)
    {
        $unit = TeachingUnit::with('filiere')->findOrFail($id);
        $profs = User::where('role', 'professor')
            ->get();

        return view('DepartmentHead/assignUnit', compact('unit', 'profs'));
    }

    public function reassign($id)
    {
        $unit = TeachingUnit::with('filiere')->findOrFail($id);
        $current_prof = Assignment::where('unit_id', $unit->id)->first()?->professor;
        $profs = User::where('role', 'professor')
            ->whereNotIn('id', [$current_prof->id])
            ->get();


        return view('DepartmentHead/editAssignUnit', compact('unit', 'profs', 'current_prof'));
    }

    public function assignDB(Request $request, $unit_id)
    {
        // Validate request data
        $request->validate([
            'prof_id' => 'required|exists:users,id',
        ]);

        // Find the existing assignment for this unit
        $assignment = Assignment::where('unit_id', $unit_id)->first();

        if ($assignment) {
            // Update the professor in the existing assignment
            $assignment->update([
                'professor_id' => $request->input('prof_id'),
                'status' => Assignment::STATUS_PENDING, // Optional: Reset status
            ]);
        } else {
            // Create a new assignment if none exists
            Assignment::create([
                'professor_id' => $request->input('prof_id'),
                'unit_id' => $unit_id,
                'status' => Assignment::STATUS_PENDING, // Default status
            ]);
        }

        // Redirect with a success message
        return redirect()->route('TeachingUnits')->with('success', 'Professor assigned successfully!');
    }

    public function showProfessors()
    {
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

        return view('DepartmentHead/ProfessorsList', compact('profsWithUnits'));
//        return view('DepartmentHead/ProfessorsList', compact('professors', 'department_id'));
    }
}

