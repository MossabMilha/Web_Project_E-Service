<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\TeachingUnit;
use Illuminate\Http\Request;

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

    public function AddUnit(Request $request, $coordinatorId)
    {
        // Validate the input
        $validated = $request->validate([
            'add-name' => 'required|string|max:255',
            'add-description' => 'required|string',
            'add-hours' => 'required|integer',
            'add-type' => 'required|string',
            'add-credits' => 'required|integer',
            'add-filiere' => 'required|integer',  // Filiere ID
            'add-semester' => 'required|integer', // Semester (1 or 2)
        ]);

        // Create the new teaching unit using the 'create' method
        TeachingUnit::create([
            'name' => $request->input('add-name'),
            'description' => $request->input('add-description'),
            'hours' => $request->input('add-hours'),
            'type' => $request->input('add-type'),
            'credits' => $request->input('add-credits'),
            'filiere_id' => $request->input('add-filiere'),
            'semester' => $request->input('add-semester'),
        ]);

        // Redirect back to the teaching units page with success message
        return redirect()->route('Coordinator.teachingUnits',['id'=>$coordinatorId])->with('success', 'Teaching unit added successfully!');
    }


}
