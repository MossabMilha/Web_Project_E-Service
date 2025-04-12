<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Filiere;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CoordinatorController extends Controller
{
    public function teachingUnits(){
        $coordinatorId = Auth::user()->id;

        $filieres = Filiere::where('coordinator_id', $coordinatorId)->with('TeachingUnits')->get();


        $allTeachingUnits = $filieres->flatMap(function($filiere) {
            return $filiere->TeachingUnits;
        });

        return view('/Coordinator/TeachingUnits', compact('allTeachingUnits', 'filieres', 'coordinatorId'));
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

        // Return back with success message
        return redirect()->route('Coordinator.teachingUnits', ['id' => $Id])
            ->with('success', 'Teaching unit added successfully!');
    }
    public function AddVacataire(){
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

        return redirect()->route('VacataireAccount')->with('success', 'User added successfully!');
    }
    public function VacataireAccount()
    {
        $users = User::where('role', 'vacataire')->get();
        return view('/Coordinator/VacataireAccount',compact('users'));
    }
    public function VacataireInformation($id)
    {
        $user = User::findOrFail($id);
        return view('/Coordinator/VacataireInfo',compact('user'));
    }
    public function AssignedTeachingUnit($UnitId){
        $unit = TeachingUnit::findOrFail($UnitId);
        $vacataires = Auth::user()->unassignedVacataires();

        return view('/Coordinator/AssignedTeachingUnit', compact('unit','vacataires'));

    }
    public function ReAssignedTeachingUnit($UnitId){
        $unit = TeachingUnit::findOrFail($UnitId);
        $oldVacataire = User::find($unit->assignedProfessorId());
        $vacataires = Auth::user()->unassignedVacataires();

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



        return redirect()->route('Coordinator.teachingUnits')->with('success', 'Vacataire Re-assigned successfully!');
    }




}
