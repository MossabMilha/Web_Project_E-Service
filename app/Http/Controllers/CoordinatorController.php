<?php

namespace App\Http\Controllers;

use App\Exports\ScheduleExport;
use App\Exports\UserExport;
use App\Models\Assignment;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\Schedule;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

use App\Models\LogModel;

class CoordinatorController extends Controller
{
    public function teachingUnits(Request $request)
    {
        $coordinatorId = Auth::id();

        // Cache filieres for 6 hours
        $filieres = Cache::remember('coordinator_filieres_'.$coordinatorId, now()->addHours(6), function() use ($coordinatorId) {
            return Filiere::with('user')
                ->where('coordinator_id', $coordinatorId)
                ->get();
        });

        $filiereIds = $filieres->pluck('id');

        // Eager load all necessary relationships with optimized queries
        $query = TeachingUnit::with([
            'filiere',
            // Load all assignments in one query
            'assignments' => function($q) {
                $q->whereNotNull('unit_id')
                    ->orderBy('created_at', 'desc')
                    ->with('professor'); // Eager load professor too
            }
        ])->whereIn('filiere_id', $filiereIds);

        // Apply filters
        $filters = [
            'type' => 'type',
            'filiere' => 'filiere_id',
            'semester' => 'semester',
            'status' => 'status'
        ];

        foreach ($filters as $requestKey => $column) {
            if ($request->$requestKey && $request->$requestKey != 'all') {
                $query->where($column, $request->$requestKey);
            }
        }

        // Apply sorting
        if ($request->has('sort_by')) {
            $sortColumn = $request->sort_by;
            $sortDirection = $request->has('sort_direction') ? $request->sort_direction : 'asc';

            $validSortColumns = ['id', 'created_at', 'updated_at'];
            if (in_array($sortColumn, $validSortColumns)) {
                $query->orderBy($sortColumn, $sortDirection);
            }
        }

        // Paginate results
        $allTeachingUnits = $query->paginate(10);

        // Precompute all necessary data for the view
        $allTeachingUnits->getCollection()->transform(function($unit) {
            // Get the latest assignment with professor
            $unit->latestAssignment = $unit->assignments
                ->where('professor_id', '!=', null)
                ->sortByDesc('created_at')
                ->first();

            // Precompute status
            $unit->computedStatus = $unit->assignments->isEmpty()
                ? 'unassigned'
                : ($unit->latestAssignment ? 'assigned' : 'unassigned');

            // Precompute vacataire
            $unit->computedVacataire = $unit->latestAssignment
                ? $unit->latestAssignment->professor
                : null;

        // Precompute all necessary data for the view
//        $allTeachingUnits->getCollection()->transform(function($unit) {
//            // Get all assignments sorted by newest first
//            $sortedAssignments = $unit->assignments->sortByDesc('created_at');
//
//            // Find the latest assignment in each state
//            $latestPending = $sortedAssignments->where('status', 'pending')->first();
//            $latestAccepted = $sortedAssignments->where('status', 'accepted')->first();
//            $latestRejected = $sortedAssignments->where('status', 'rejected')->first();

            // Determine the actual status
//            if ($latestAccepted) {
//                $unit->computedStatus = 'assigned';
//                $unit->computedVacataire = $latestAccepted->professor;
//                $unit->latestAssignment = $latestAccepted;
//            } elseif ($latestPending) {
//                $unit->computedStatus = 'pending';
//                $unit->computedVacataire = $latestPending->professor;
//                $unit->latestAssignment = $latestPending;
//            } elseif ($unit->assignments->isNotEmpty()) {
//                $unit->computedStatus = 'unassigned'; // Has assignments but none accepted/pending
//                $unit->computedVacataire = null;
//                $unit->latestAssignment = null;
//            } else {
//                $unit->computedStatus = 'unassigned'; // No assignments at all
//                $unit->computedVacataire = null;
//                $unit->latestAssignment = null;
//            }
            // TODO: Some assignments were made before status tracking was implemented

            return $unit;
        });

        // Log the visit
        LogModel::track('visit_teaching_units', "Coordinator (ID: {$coordinatorId}) visited Teaching Units page.");

        return view('Coordinator.TeachingUnits', compact('allTeachingUnits', 'filieres', 'coordinatorId'));
    }

    public function AddUnit(Request $request)
    {
        $coordinatorId = session('user_id');

        $validated = $request->validate([
            'add-name' => 'required|string|max:255',
            'add-description' => 'required|string',
            'add-hours' => 'required|integer|min:1',
            'add-type' => 'required|string|in:CM,TD,TP',
            'add-credits' => 'required|integer|min:1',
            'add-filiere' => 'required|exists:filieres,id',  // Check if Filiere exists
            'add-semester' => 'required|integer|in:1,2', // Must be 1 or 2
        ]);

        // Create the new teaching unit
        TeachingUnit::create([
            'name' => $validated['add-name'],
            'description' => $validated['add-description'],
            'hours' => $validated['add-hours'],
            'type' => $validated['add-type'],
            'credits' => $validated['add-credits'],
            'filiere_id' => $validated['add-filiere'],
            'semester' => $validated['add-semester'],
        ]);
        LogModel::track('unit_created', "Coordinator (ID: {$coordinatorId}) added a unit: {$validated['add-name']}");
        return redirect()->route('Coordinator.teachingUnits')
            ->with('success', 'Teaching unit added successfully!');
    }
    public function EdtUnit(Request $request)
    {
        $Id = session('user_id');
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'hours' => 'required|integer|min:1',
            'type' => 'required|in:CM,TD,TP',
            'credits' => 'required|integer|min:1',
            'filiere' => 'required|string',
            'semester' => 'required|string',
            'password' => 'required|string',
        ]);

        // Verify user password manually
        $user = User::findOrFail($Id);
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('Coordinator.teachingUnits', ['id' => $Id])
                ->withErrors(['password' => 'Incorrect password']);
        }

        // Access the unitId from the form data
        $unitId = $request->input('UnitID');

        // Find the teaching unit using the unitId and update it
        $unit = TeachingUnit::findOrFail($unitId);
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->hours = $request->hours;
        $unit->type = $request->type;
        $unit->credits = $request->credits;
        $unit->semester = $request->semester;
        $unit->updated_at = now();
        $unit->filiere_id = $request->filiere;


        // Save the updated teaching unit
        $unit->save();


        LogModel::track('unit_updated', "Coordinator (ID: {$Id}) edited unit ID: {$unitId} - new name: {$unit->name}");

        return redirect()->route('Coordinator.teachingUnits', ['id' => $Id])
            ->with('success', 'Teaching unit added successfully!');
    }
    public function AddVacataire(){
        LogModel::track('visit_add_vacataire', "Coordinator (ID: " . Auth::user()->id . ") visited Add Vacataire form.");

        return view('/Coordinator/AddVacataire');

    }
    public function AddVacataireDb(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255',
            'specialization' => 'required|string',
        ]);

        $valid = true;
        $errors = [];


        $validNameResult = User::validName($request->input('name'));
        if ($validNameResult !== true) {
            $errors['name'] = $validNameResult;
            $valid = false;
        }


        $validEmailResult = User::validEmail($request->input('email'));
        if ($validEmailResult !== true) {
            $errors['email'] = $validEmailResult;
            $valid = false;
        }


        $validPhoneResult = User::validPhoneNumber($request->input('phone'));
        if ($validPhoneResult !== true) {
            $errors['phone'] = $validPhoneResult;
            $valid = false;
        }

        if (!$valid) {
            return redirect()->back()->withInput()->withErrors($errors);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = 'vacataire';
        $user->specialization = $request->input('specialization');
        $user->password = Hash::make('password');

        $user->save();
        LogModel::track('vacataire_created', "Coordinator (ID: " . Auth::user()->id . ") added vacataire: {$user->name} (ID: {$user->id})");


        return redirect()->route('VacataireAccount')->with('success', 'User added successfully!');
    }
    public function VacataireAccount(){
        $departmentId = Filiere::where('coordinator_id', Auth::id())->value('department_id');
        $userIds = DepartmentMember::where('department_id', $departmentId)
            ->pluck('professor_id');
        $users = User::whereIn('id', $userIds)->where('role', 'vacataire')->get();



        LogModel::track('visit_vacataire_account', "Coordinator (ID: " . Auth::user()->id . ") visited Vacataire Account list.");


        return view('/Coordinator/VacataireAccount',compact('users'));
    }
    public function VacataireInformation($id)
    {
        LogModel::track('visit_vacataire_info', "Coordinator (ID: " . Auth::user()->id . ") viewed Vacataire details for ID: {$id}.");
        $user = User::findOrFail($id);
        return view('/Coordinator/VacataireInfo',compact('user'));
    }
    public function AssignedTeachingUnit($UnitId){

        $unit = TeachingUnit::findOrFail($UnitId);
        $vacataires = Auth::user()->unassignedVacataires();

        LogModel::track('visit_assign_unit', "Coordinator (ID: " . Auth::user()->id . ") opened assignment page for Unit ID: {$UnitId}");

        return view('/Coordinator/AssignedTeachingUnit', compact('unit','vacataires'));

    }
    public function ReAssignedTeachingUnit($UnitId){
        $unit = TeachingUnit::findOrFail($UnitId);
        $oldVacataire = User::find($unit->assignedProfessorId());
        $vacataires = Auth::user()->unassignedVacataires();

        LogModel::track('visit_reassign_unit', "Coordinator (ID: " . Auth::user()->id . ") opened reassignment page for Unit ID: {$UnitId}");

        return view('/Coordinator/ReAssignedTeachingUnit', compact('unit','vacataires','oldVacataire'));

    }
    public function getVacataireDetails($id)
    {
        $vacataire = User::findOrFail($id);
        return response()->json($vacataire);
    }
    public function AssignedTeachingUnitDB(Request $request){
        $request->validate([
            'professor_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:teaching_units,id',
            'password' => 'required',
        ]);

        $user = Auth::user();

        // Check if the password is correct
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

        // Save assignment
        Assignment::create([
            'professor_id' => $request->professor_id,
            'unit_id' => $request->unit_id,
            'status' => 'approved',
        ]);
        LogModel::track('unit_assigned', "Coordinator (ID: " . Auth::user()->id . ") assigned unit ID: {$request->unit_id} to vacataire ID: {$request->professor_id}");

        return redirect()->route('Coordinator.teachingUnits')->with('success', 'Vacataire assigned successfully!');
    }
    public function ReAssignedTeachingUnitDB(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'professor_id' => 'required|exists:users,id',  // Ensure the new professor exists
            'unit_id' => 'required|exists:teaching_units,id', // Ensure the unit exists
        ]);

        // Get the currently authenticated user
        $user = Auth::user();


        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

        // Get the old and new professor details
        $oldVacataire = User::find($request->input('old-professor_id'));
        $newVacataire = User::find($request->input('professor_id'));

        if (!$oldVacataire || !$newVacataire) {
            return back()->withErrors(['professor' => 'Invalid professor IDs provided']);
        }

        // Find the existing assignment record that links the old professor to the unit
        $assignment = Assignment::where('unit_id', $request->unit_id)
            ->where('professor_id', $oldVacataire->id)
            ->first();

        if (!$assignment) {
            return back()->withErrors(['assignment' => 'No assignment found for the specified unit and professor']);
        }


        $assignment->professor_id = $newVacataire->id;
        $assignment->status = 'approved';
        $assignment->save();

        LogModel::track('unit_reassigned', "Coordinator (ID: " . Auth::user()->id . ") reassigned unit ID: {$request->unit_id} from vacataire ID: {$oldVacataire->id} to ID: {$newVacataire->id}");




        return redirect()->route('Coordinator.teachingUnits')->with('success', 'Vacataire Re-assigned successfully!');
    }
    //Schedule Management Section

    public function ScheduleManagement()
    {
        LogModel::track('visit_schedule_management', "Coordinator (ID: " . Auth::user()->id . ") visited Schedule Management main page.");
        $filieres = Filiere::where('coordinator_id', Auth::user()->id)->get();
        return view('Coordinator/ScheduleManagement/ScheduleManagement', compact('filieres'));
    }
    public function ScheduleManagementFiliere(Request $request, $name)
    {
        $filiereId = $request->input('filiere_id');
        $filiere = Filiere::find($filiereId);

        // Get the schedules for both semesters
        $semester1Schedules = Schedule::where('filiere_id', $filiereId)
            ->where('semestre', 1)
            ->with(['teachingUnit', 'enseignant'])  // Eager load the relationships
            ->get();

        $semester2Schedules = Schedule::where('filiere_id', $filiereId)
            ->where('semestre', 2)
            ->with(['teachingUnit', 'enseignant'])  // Eager load the relationships
            ->get();

        LogModel::track('visit_schedule_filiere', "Coordinator (ID: " . Auth::user()->id . ") viewed schedule for Filiere ID: {$filiereId}");
        return view('Coordinator.ScheduleManagement.ScheduleManagementFiliere', compact('filiere', 'semester1Schedules', 'semester2Schedules'));

    }


    public function convertTimeToSlot($time)
    {
        // Example map
        $slots = [
            '08:00 - 10:00' => 1,
            '10:00 - 12:00' => 2,
            '14:00 - 16:00' => 3,
            '16:30 - 18:30' => 4,
        ];

        return $slots[$time] ?? 0; // default to 0 if not found
    }
    public function ScheduleManagementFiliereImport(Request $request, Filiere $filiere)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
            'semestre' => 'required|integer|in:1,2',
        ]);

        try {

            $rows = Excel::toCollection(null, $request->file('file'))[0];
            $rows = $rows->toArray();
            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // skip header row if needed

                Schedule::create([
                    'jour' => $row[0],
                    'time_slot' => $this->convertTimeToSlot($row[1]), // You’ll define this function
                    'filiere_id' => $filiere->id, // You already have the filiere from the route
                    'module_id' => $row[2],
                    'enseignant_id' => $row[3],
                    'salle' => $row[4],
                    'semestre' => $request->semestre,
                ]);
            }
            LogModel::track('schedule_import', "Coordinator (ID: " . Auth::user()->id . ") imported schedule for filiere ID: {$filiere->id}, semester: {$request->semestre}");

            return redirect()->route('Coordinator.ScheduleManagement')->with('success', 'Importation terminée avec succès pour le semestre ' . $request->semestre);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Erreur d\'importation : ' . $e->getMessage());
        }
    }


    public function exportUsers($id = null)
    {
        $role = request('role'); // Get the role from the request

        if ($id) {
            $user = User::findOrFail($id);

            LogModel::track('export_users', "Coordinator (ID: " . Auth::user()->id . ") exported user information for User ID: " . $user->id);

            return Excel::download(new UserExport([$user]), 'user_' . $user->id . '.xlsx');  // Wrap single user in an array
        }

        if ($role) {
            $users = User::where('role', $role)->get();

            LogModel::track('export_users', "Coordinator (ID: " . Auth::user()->id . ") exported all $role user information.");

            return Excel::download(new UserExport($users), $role . '_users.xlsx');
        }

        $users = User::all();

        LogModel::track('export_users', "Coordinator (ID: " . Auth::user()->id . ") exported all user information.");

        return Excel::download(new UserExport($users), 'users.xlsx');
    }
    public function DeleteVacataire(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if the password is correct
        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

        $user = User::findOrFail($request->user_id);

        // Check if the vacataire is assigned to any teaching unit
        $hasAssignments = Assignment::where('professor_id', $user->id)->exists();

        if ($hasAssignments) {
            return back()->withErrors(['user' => 'Cannot delete this vacataire because they are assigned to at least one teaching unit.']);
        }

        $user->delete();

        LogModel::track('vacataire_deleted', "Coordinator (ID: " . Auth::user()->id . ") deleted vacataire ID: {$user->id}");

        return redirect()->route('VacataireAccount')->with('success', 'Vacataire deleted successfully!');
    }

    public function exportSchedule($filiereId, $semester)
    {
        $filiere = Filiere::findOrFail($filiereId);
        $filiereNameSlug = Str::slug($filiere->name); // Converts "Informatique L3" -> "informatique-l3"

        return Excel::download(
            new ScheduleExport($filiereId, $semester),
            "schedule_{$filiereNameSlug}_semester_{$semester}.xlsx"
        );
    }





}
