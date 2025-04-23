<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Assignment;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VacataireController extends Controller
{
    public function assignedUnit()
    {
        $assignments = Assignment::with('filiere')->where('professor_id', auth()->user()->id)->get();
        return view('/Vacataire/assignedUnit', compact('assignments'));
    }
    public function assessments(){
        $userId = Auth::user()->id;

        $assessments = Assessment::where('professor_id', $userId)->get();

        $filiereIds = $assessments->pluck('filiere')->unique();
        $filieres = Filiere::whereIn('id', $filiereIds)->get();

        foreach ($assessments as $assessment) {

            $assessment->filiere = $filieres->firstWhere('id', $assessment->filiere);
        }


        return view('/Vacataire/assessments', compact('assessments'));

    }
    public function NewAssessments(){
        $userId = Auth::user()->id;
        // Get all modules assigned to the professor, with their filière info
        $rows = \DB::table('assignments')
            ->join('teaching_units', 'assignments.unit_id', '=', 'teaching_units.id')
            ->join('filieres', 'teaching_units.filiere_id', '=', 'filieres.id')
            ->where('assignments.professor_id', $userId)
            ->where('assignments.status', 'approved')
            ->select(
                'filieres.id as filiere_id',
                'filieres.name as filiere_name',
                'teaching_units.id as module_id',
                'teaching_units.name as module_name',
                'teaching_units.type',
                'teaching_units.hours',
                'teaching_units.description',
                'teaching_units.credits',
                'teaching_units.semester',
                'teaching_units.filiere_id'
            )
            ->get();

        // Group modules by filière
        $filieres = [];

        foreach ($rows as $row) {
            $filiereId = $row->filiere_id;

            if (!isset($filieres[$filiereId])) {
                $filieres[$filiereId] = (object)[
                    'id' => $filiereId,
                    'name' => $row->filiere_name,
                    'modules' => []
                ];
            }

            $filieres[$filiereId]->modules[] = (object)[
                'id' => $row->module_id,
                'name' => $row->module_name,
                'type' => $row->type,
                'hours' => $row->hours,
                'description' => $row->description,
                'credits' => $row->credits,
                'semester' => $row->semester
            ];
        }

        return view('/Vacataire/AddAssessments', ['filieres' => array_values($filieres)]);
    }
    public function NewAssessmentsDB(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'filiere_id' => 'required|exists:filieres,id',
            'unit_id' => 'required|exists:teaching_units,id',
            'semester' => 'required|string',
        ]);

        // Saving the assessment
        Assessment::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'filiere' => $validated['filiere_id'],  // Store the ID, not the object
            'teaching_unit_id' => $validated['unit_id'],
            'semester' => (int) $validated['semester'],
            'professor_id' => auth()->id()
        ]);

        return redirect()->route('Vacataire.assessments')->with('success', 'Assessment added successfully.');
    }
}
