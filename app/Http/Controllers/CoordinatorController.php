<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\TeachingUnit;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function teachingUnits($coordinatorId)
    {
        // Retrieve all Filiere instances and their associated TeachingUnits
        $filieres = Filiere::where('coordinator_id', $coordinatorId)->with('TeachingUnits')->get();

        // Collect all the teaching units related to these Filiere instances
        $allTeachingUnits = $filieres->flatMap(function($filiere) {
            return $filiere->TeachingUnits;
        });

        return view('CoordinatorTeachingUnits', compact('allTeachingUnits'));
    }
}
