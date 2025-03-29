<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoordinatorController extends Controller
{
    public function teachingUnits($coordinatorId){
        // Retrieve all Filiere instances and their associated TeachingUnits
        $filieres = Filiere::where('coordinator_id', $coordinatorId)->with('TeachingUnits')->get();

        // Collect all the teaching units related to these Filiere instances
        $allTeachingUnits = $filieres->flatMap(function($filiere) {
            return $filiere->TeachingUnits;
        });

        return view('CoordinatorTeachingUnits', compact('allTeachingUnits', 'filieres', 'coordinatorId'));
    }

    public function AddUnit(Request $request, $CoordinatorId)
    {
        // Validate input data
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

        return redirect()->route('Coordinator.teachingUnits', ['id' => $CoordinatorId])
            ->with('success', 'Teaching unit added successfully!');
    }
    public function EdtUnit(Request $request,$CoordinatorId)
    {
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
        $user = User::findOrFail($CoordinatorId);
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('Coordinator.teachingUnits', ['id' => $CoordinatorId])
                ->withErrors(['password' => 'Incorrect password']);
        }

        // Access the unitId from the form data
        $unitId = $request->input('unitId');

        // Find the teaching unit using the unitId and update it
        $unit = TeachingUnit::findOrFail($unitId);
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->hours = $request->hours;
        $unit->type = $request->type;
        $unit->credits = $request->credits;
        $unit->filiere = $request->filiere;
        $unit->semester = $request->semester;

        // Save the updated teaching unit
        $unit->save();

        // Return back with success message
        return redirect()->route('Coordinator.teachingUnits', ['id' => $CoordinatorId])
            ->with('success', 'Teaching unit added successfully!');
    }



}
