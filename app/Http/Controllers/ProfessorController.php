<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\LogModel;
use App\Models\TeachingUnit;
use App\Models\UnitsRequest;
use App\Models\User;
use App\Models\WorkloadProfile;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{

    public function index(){
        $department_id = Department::where('head_id', Auth::user()->id)->first()->id;

        $professors = User::where('role', 'professor')
            ->whereHas('departmentMember', function ($query) use ($department_id) {
                $query->where('department_id', $department_id);
            })
            ->with('departmentMember')
            ->paginate(10);

        return view('department_head.professors.index', compact('professors'));
    }
    public function search(Request $request)
    {
        $authUser = Auth::user();

        // Get department ID led by this department head
        $department = Department::where('head_id', $authUser->id)->first();

        if (!$department) {
            abort(403, 'You are not assigned as head of any department.');
        }

        $departmentId = $department->id;

        LogModel::track('search_users', "Department Head (ID: {$authUser->id}) searched users in department ID {$departmentId} with term '{$request->input('search')}' and option '{$request->input('option')}'");

        $searchTerm = $request->input('search');
        $searchOption = $request->input('option', 'id');

        // Map frontend search options to database columns
        $columnMap = [
            'id' => 'users.id',
            'full name' => 'users.name',
            'email' => 'users.email',
            'role' => 'users.role',
            'specialization' => 'users.specialization',
        ];

        $searchOption = $columnMap[$searchOption] ?? 'users.id';

        // Build query
        $query = User::query()
            ->select('users.*')
            ->join('department_members', 'users.id', '=', 'department_members.professor_id')
            ->where('department_members.department_id', $departmentId)
            ->where('users.role', 'professor');

        // Apply search if any
        if ($searchTerm) {
            if ($searchOption === 'users.id') {
                $query->whereRaw("CAST(users.id AS CHAR) LIKE ?", ['%' . $searchTerm . '%']);
            } else {
                $query->where($searchOption, 'like', '%' . $searchTerm . '%');
            }
        }

        $professors = $query->paginate(10)->appends(request()->query());

        return view('department_head.professors.index', compact('professors'));
    }


//    public function assign($id)
//    {
//        $department_id = DepartmentMember::where('professor_id', $id)->value('department_id');
//        $filiere = Filiere::where('department_id', $department_id)->get();
//
//        $professor = User::find($id);
//        $units = TeachingUnit::
//        whereDoesntHave('assignments')
//            ->whereHas('filiere', function($q) use($filiere){
//                $q->whereIn('id', $filiere->pluck('id'));
//            })
//            ->get();
//
//        return view('department_head.professors.assign', compact('professor', 'units'));
//    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'professor_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:teaching_units,id',
        ]);

        $existingAssignment = Assignment::where('unit_id', $request->unit_id)->exists();

        if ($existingAssignment) {
            return redirect()->back()->with('error', 'This unit is already assigned to a professor.');
        }

        Assignment::create([
            'professor_id' => $request->professor_id,
            'unit_id' => $request->unit_id,
            'status' => 'approved',
        ]);

        return redirect()->route('department-head.teaching-units.index')
            ->with('success', 'Unit assigned successfully!');
    }

    public function destroyAssignment($unit_id)
    {
        $assignment = Assignment::where('unit_id', $unit_id)
            ->first();

        if ($assignment) { // Check if assignment exists
            $assignment->delete();
            return redirect()->route('department-head.teaching-units.index')->with('success', 'Unit assignment was deleted successfully.');
        }

        return redirect()->route('department-head.teaching-units.index')->with('error', 'Unit assignment not found.');
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

    public function showAssignedUnits($id)
    {
        $approvedUnits = TeachingUnit::whereHas('assignments', function($query) use ($id) {
            $query->where('professor_id', $id)
                  ->where('status', 'approved');
        })->get();

        return view('professor.assigned-units', compact('approvedUnits'));
    }

    public function indexUnitRequests()
    {
        $perPage = 10;

        // First, get paginated requests with eager-loaded relationships
        $paginatedRequests = UnitsRequest::with(['professor', 'unit'])
            ->where('status', 'pending')
            ->paginate($perPage)
            ->appends(request()->query());

        // Map the items while preserving the pagination structure
        $modifiedItems = $paginatedRequests->getCollection()->map(function ($request) {
            $professor = $request->professor;

            $assigned_hours = Assignment::
            join('teaching_units', 'assignments.unit_id', '=', 'teaching_units.id')
                ->where('assignments.professor_id', $professor->id)
                ->sum('teaching_units.hours');

            $workloadProfile = WorkloadProfile::where('type', $professor->role)->first();

            $request->underloaded = $assigned_hours < $workloadProfile->min_hours;
            $request->overloaded = $assigned_hours > $workloadProfile->max_hours;
            $request->assigned_hours = $assigned_hours;
            $request->min_hours = $workloadProfile->min_hours;
            $request->max_hours = $workloadProfile->max_hours;


            return $request;
        });

        // Replace original collection with modified one
        $unit_requests = new LengthAwarePaginator(
            $modifiedItems,
            $paginatedRequests->total(),
            $paginatedRequests->perPage(),
            $paginatedRequests->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
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
                    'unit_id' => $unit_request->unit_id,
                ],
                [
                    'status' => 'approved',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $unit_request->save();
            return redirect()->back()->with('success', 'Unit request approved and assignment created.');
        } elseif ($action === 'reject') {
            $unit_request->status = 'rejected';
            $unit_request->save();
            return redirect()->back()->with('info', 'Unit request rejected.');
        }
        return redirect()->back()->with('error', 'Invalid action.');
    }

}
