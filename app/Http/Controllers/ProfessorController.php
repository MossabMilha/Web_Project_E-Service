<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\TeachingUnit;
use App\Models\UnitsRequest;
use App\Models\User;
use App\Models\WorkloadProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{

    public function index(){
        $department = Department::where('head_id', Auth::user()->id)->first();
        $department_id = $department->id;

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
            }
            $profsWithUnits[] = [
                'professor' => $professor,
                'units' => $units,
            ];
        }

        $unitsToAssign = TeachingUnit::whereDoesntHave('assignments')
            ->whereDoesntHave('unitsRequest')
            ->whereHas('filiere', function($q) use ($department_id) {
                $q->where('department_id', $department_id);
            })
            ->get();

        return view('department_head.professors.index', compact( 'profsWithUnits', 'unitsToAssign'));
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

        return view('department_head.professors.assign', compact('professor', 'units'));
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

    //professor methods
    public function unitRequestForm($id)
    {

        $professor = User::find($id);
        $department_id = DepartmentMember::where('professor_id', $professor->id)->value('department_id');
        $filiere = Filiere::where('department_id', $department_id)->get();

        $units = TeachingUnit::
        whereDoesntHave('assignments')
            ->whereDoesntHave('unitsRequest')
            ->whereHas('filiere', function($q) use($filiere){
                $q->whereIn('id', $filiere->pluck('id'));
            })
            ->get();

        $requests = UnitsRequest::
        whereHas('professor', function($q) use($professor){
            $q->where('id', $professor->id);
            })
            ->with('unit')
            ->orderByDesc('requested_at')
            ->paginate(10)->appends(request()->query());
        return view('professor.request-units', compact('professor', 'units', 'requests'));
    }

    public  function storeRequest(Request $request, $professor_id)
    {
        $request->merge([
            'requested_units' => json_decode($request->input('requested_units'), true)
        ]);
        // Validate the input to ensure selected_units_id is an array and contains valid unit IDs
        $request->validate([
            'requested_units' => 'required|array', // Ensure it's an array
            'requested_units.*' => 'exists:teaching_units,id', // Ensure each unit_id exists in the teaching_units table
            'semester' => 'required|integer|min:1|max:5',
            'academic_year' => 'required|string',
        ]);

        // Retrieve the selected unit IDs from the request
        $requested_units_ids = $request->input('requested_units');

        // Avoid duplicate requests for the same unit by this professor
        $existing_requests = UnitsRequest::
            where('professor_id', $professor_id)
            ->whereIn('unit_id', $requested_units_ids)
            ->pluck('unit_id')
            ->toArray();

        $units_to_request = array_diff($requested_units_ids, $existing_requests);

        if (count($units_to_request) > 0) {
            $requests = array_map(function ($unit_id) use ($professor_id, $request) {
                return [
                    'professor_id' => $professor_id,
                    'unit_id' => $unit_id,
                    'semester' => $request->input('semester'),
                    'academic_year' => $request->input('academic_year'),
                    'status' => 'pending', // Default status
                    'requested_at' => now(),
                ];
            }, $units_to_request);

            UnitsRequest::insert($requests);

            return redirect()->route('professor.units.request', $professor_id)->with('success', 'Unit(s) requested successfully!');
        } else {
            return redirect()->route('professor.units.request', $professor_id)->with('info', 'The selected unit(s) are already requested by this professor.');
        }
    }

    public function indexUnitRequests()
    {
        $unit_requests = UnitsRequest::with(['professor', 'unit'])->where('status', 'pending')->get();

        // Map with workload status
        $unit_requests = $unit_requests->map(function ($request) {
            $professor = $request->professor;
            $assigned_hours = Assignment::
                join('teaching_units', 'assignments.unit_id', '=', 'teaching_units.id')
                ->where('assignments.professor_id', $professor->id)
                ->sum('teaching_units.hours');

            $workloadProfile = WorkloadProfile::where('type', $professor->role)->first();

            $request->underloaded = $assigned_hours < $workloadProfile->min_hours;
            $request->assigned_hours = $assigned_hours;
            $request->min_hours = $workloadProfile->min_hours;

            return $request;
        });

        // Sort so underloaded professors come first
        $unit_requests = $unit_requests->sortByDesc('underloaded');

        return view('department_head.professors.unitRequests', compact('unit_requests'));
    }


    public function handleUnitRequests(Request $request, $unit_request_id){
        $unit_request = UnitsRequest::find($unit_request_id);
        $action = $request->input('action');

        if (!$unit_request) {
            return redirect()->back()->with('error', 'Unit request not found.');
        }

        if ($action === 'approve') {
            $unit_request->status = 'approved';

            // Assign the professor to the unit
            Assignment::updateOrInsert(
                [
                    'professor_id' => $unit_request->professor_id,
                    'unit_id' => $unit_request->unit_id
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        } elseif ($action === 'reject') {
            $unit_request->status = 'rejected';
        }

        $unit_request->reviewed_at = now();
        $unit_request->save();

        return redirect()->back()->with('success', "Request has been {$action}ed.");
    }

}
