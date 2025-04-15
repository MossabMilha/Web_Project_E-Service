<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Filiere;
use App\Models\Schedule;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Add the Log facade
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LogModel; // Assuming LogModel is in the appropriate namespace

class CoordinatorController extends Controller
{
    // Log when accessing teaching units
    public function teachingUnits(){
        $coordinatorId = Auth::user()->id;

        $filieres = Filiere::where('coordinator_id', $coordinatorId)->with('TeachingUnits')->get();
        $allTeachingUnits = $filieres->pluck('teachingUnits')->collapse();

        // Log the action with detailed information
        LogModel::track('access_teaching_units', "Coordinator (ID: {$coordinatorId}) accessed the teaching units list.");

        return view('/Coordinator/TeachingUnits', compact('allTeachingUnits', 'filieres', 'coordinatorId'));
    }

    // Log when adding a new teaching unit
    public function AddUnit(Request $request)
    {
        $coordinatorId = session('user_id');

        // Validate the incoming request
        $validated = $request->validate([
            'add-name' => 'required|string|max:255',
            'add-description' => 'required|string',
            'add-hours' => 'required|integer|min:1',
            'add-type' => 'required|string|in:CM,TD,TP',
            'add-credits' => 'required|integer|min:1',
            'add-filiere' => 'required|exists:filieres,id',
            'add-semester' => 'required|integer|in:1,2',
        ]);

        // Create the new teaching unit
        $unit = TeachingUnit::create([
            'name' => $validated['add-name'],
            'description' => $validated['add-description'],
            'hours' => $validated['add-hours'],
            'type' => $validated['add-type'],
            'credits' => $validated['add-credits'],
            'filiere_id' => $validated['add-filiere'],
            'semester' => $validated['add-semester'],
        ]);

        // Log the action with detailed information
        LogModel::track('add_teaching_unit', "Coordinator (ID: {$coordinatorId}) added a new teaching unit. Name: {$validated['add-name']}, Description: {$validated['add-description']}, Type: {$validated['add-type']}, Credits: {$validated['add-credits']}, Filiere ID: {$validated['add-filiere']}, Semester: {$validated['add-semester']}");

        return redirect()->route('Coordinator.teachingUnits')
            ->with('success', 'Teaching unit added successfully!');
    }

    // Log when editing a teaching unit
    public function EdtUnit(Request $request)
    {
        $Id = session('user_id');

        // Validate incoming data
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

        // Verify the password
        $user = User::findOrFail($Id);
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('Coordinator.teachingUnits', ['id' => $Id])
                ->withErrors(['password' => 'Incorrect password']);
        }

        // Find the unit and update it
        $unitId = $request->input('UnitID');
        $unit = TeachingUnit::findOrFail($unitId);
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->hours = $request->hours;
        $unit->type = $request->type;
        $unit->credits = $request->credits;
        $unit->semester = $request->semester;
        $unit->filiere_id = $request->filiere;
        $unit->save();

        // Log the action with detailed information
        LogModel::track('edit_teaching_unit', "Coordinator (ID: {$Id}) edited a teaching unit. Updated Name: {$request->name}, Description: {$request->description}, Hours: {$request->hours}, Type: {$request->type}, Credits: {$request->credits}, Semester: {$request->semester}, Filiere: {$request->filiere}");

        return redirect()->route('Coordinator.teachingUnits', ['id' => $Id])
            ->with('success', 'Teaching unit updated successfully!');
    }

    // Log when adding a new Vacataire
    public function AddVacataireDb(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255',
            'specialization' => 'required|string',
        ]);

        // Validate the data and create the new vacataire
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = 'vacataire';
        $user->specialization = $request->input('specialization');
        $user->phone = $request->input('phone');
        $user->password = Hash::make('password'); // Default password, it should be updated later
        $user->save();

        // Log the action with detailed information
        LogModel::track('add_vacataire', "Coordinator (ID: {$request->input('coordinator_id')}) added a new Vacataire. Name: {$request->input('name')}, Email: {$request->input('email')}, Phone: {$request->input('phone')}, Specialization: {$request->input('specialization')}, User ID: {$user->id}");

        return redirect()->route('VacataireAccount')->with('success', 'Vacataire added successfully!');
    }

    // Log when re-assigning a teaching unit to a vacataire
    public function ReAssignedTeachingUnitDB(Request $request)
    {
        $request->validate([
            'professor_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:teaching_units,id',
        ]);

        // Get the current user's password for verification
        $user = Auth::user();
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

        // Find the old and new vacataire
        $oldVacataire = User::find($request->input('old-professor_id'));
        $newVacataire = User::find($request->input('professor_id'));

        if (!$oldVacataire || !$newVacataire) {
            return back()->withErrors(['vacataire' => 'Invalid vacataire details']);
        }

        // Find the existing assignment and update it
        $assignment = Assignment::where('unit_id', $request->unit_id)
            ->where('professor_id', $oldVacataire->id)
            ->first();

        if (!$assignment) {
            return back()->withErrors(['assignment' => 'No assignment found for this unit and professor']);
        }

        // Reassign the vacataire
        $assignment->professor_id = $newVacataire->id;
        $assignment->save();

        // Log the action with detailed information
        LogModel::track('reassign_vacataire', "Coordinator (ID: {$user->id}) reassigned teaching unit (ID: {$request->unit_id}) from Vacataire: {$oldVacataire->name} (ID: {$oldVacataire->id}) to Vacataire: {$newVacataire->name} (ID: {$newVacataire->id})");

        return redirect()->route('Coordinator.teachingUnits')->with('success', 'Vacataire reassigned successfully!');
    }
}
