<?php

namespace App\Http\Controllers;

use App\Exports\GradesExport;
use App\Models\Assessment;
use App\Models\Assignment;
use App\Models\Filiere;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VacataireController extends Controller
{
    public function assignedUnit()
    {
        $assignments = Assignment::with('filiere')->where('professor_id', auth()->user()->id)->get();
        return view('Vacataire.assignedUnit', compact('assignments'));
    }
    public function assessments(){
        $userId = Auth::user()->id;

        $assessments = Assessment::where('professor_id', Auth::id())->get();


        foreach ($assessments as $assessment) {

            $filiere = Filiere::find($assessment->filiere);

            $assessment->filiere = $filiere;
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
    public function UploadNormalGrade(Request $request)
    {
        $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
            'file' => 'required|file|mimes:ods,xlsx,xls',
        ]);

        $assessment = Assessment::findOrFail($request->assessment_id);
        $filiere = Filiere::findOrFail($assessment->filiere);
        $students = $filiere->students;
        $totalStudents = $students->count();

        $path = $request->file('file')->getRealPath();
        $rows = IOFactory::load($path)->getActiveSheet()->toArray(null, true, true, true);

        $gradesFromSheet = [];
        foreach ($rows as $index => $row) {
            if ($index === 1) continue; // Skip header row

            $cne = trim($row['A']); // Column A = CNE
            $grade = isset($row['C']) && is_numeric($row['C']) ? floatval($row['C']) : null; // Column C = grade

            if ($cne) {
                $gradesFromSheet[$cne] = $grade;
            }
        }

        // Check attendance rate
        $presentCount = 0;
        foreach ($students as $student) {
            if (array_key_exists($student->cne, $gradesFromSheet)) {
                $presentCount++;
            }
        }

        $absentPercentage = ($totalStudents - $presentCount) / $totalStudents;

        if ($absentPercentage > 0.4) {
            return back()->withErrors(['file' => 'More than 40% of students are absent Something Is Wrong Please Contact One Of The Admin (Grades not saved !!)']);
        }


        foreach ($students as $student) {
            $cne = $student->cne;
            $grade = array_key_exists($cne, $gradesFromSheet) ? $gradesFromSheet[$cne] : 0;

            Grade::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'assessment_id' => $assessment->id
                ],
                [
                    'grade_normal' => $grade
                ]
            );
        }

        return back()->with('success', 'Grades uploaded successfully.');
    }

    public function UploadNewNormalGrade(Request $request){
        $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
            'file' => 'required|file|mimes:ods,xlsx,xls',
        ]);

        $assessmentId = $request->assessment_id;

        // Step 1: Set all existing grade_normal values to NULL
        Grade::where('assessment_id', $assessmentId)->update(['grade_normal' => null]);

        // Step 2: Load file
        $path = $request->file('file')->getRealPath();
        $rows = IOFactory::load($path)->getActiveSheet()->toArray(null, true, true, true);

        $gradesFromSheet = [];
        foreach ($rows as $index => $row) {
            if ($index === 1) continue; // Skip header

            $cne = trim($row['A']);
            $grade = isset($row['C']) && is_numeric($row['C']) ? floatval($row['C']) : null;

            if ($cne) {
                $gradesFromSheet[$cne] = $grade;
            }
        }

        // Step 3: Fetch grades with matching student CNEs
        $assessment = Assessment::findOrFail($assessmentId);
        $filiere = Filiere::findOrFail($assessment->filiere);
        $students = $filiere->students->keyBy('cne');

        foreach ($gradesFromSheet as $cne => $grade) {
            if (!isset($students[$cne])) continue;

            $studentId = $students[$cne]->id;


            Grade::where('assessment_id', $assessmentId)
                ->where('student_id', $studentId)
                ->update(['grade_normal' => $grade ?? 0]);
        }

        return back()->with('success', 'Normal grades updated successfully (existing records only, retake grades preserved).');
    }
    public function ExportGrade(Request $request){
        $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
        ]);

        // Retrieve the assessment and related data
        $assessment = Assessment::findOrFail($request->assessment_id);
        $filiere = Filiere::findOrFail($assessment->filiere);
        $students = $filiere->students;

        // Get grades related to the assessment
        $grades = Grade::where('assessment_id', $assessment->id)->get();


        foreach ($grades as $grade) {

            $grade->grade_normal = $grade->grade_normal ?? -1;
            $grade->grade_retake = $grade->grade_retake ?? -1;
        }

        // Create a filename based on the assessment name
        $fileName = 'grades_' . str_replace(' ', '_', strtolower($assessment->name)) . '.xlsx';

        // Pass the modified grades to the export class
        return Excel::download(new GradesExport($grades, $students, $assessment, $filiere), $fileName);

    }
    public function UploadRetakeGrade(Request $request){
        $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
            'file' => 'required|file|mimes:ods,xlsx,xls',
        ]);

        $assessment = Assessment::findOrFail($request->assessment_id);
        $filiere = Filiere::findOrFail($assessment->filiere);
        $students = $filiere->students;
        $totalStudents = $students->count();

        $path = $request->file('file')->getRealPath();
        $rows = IOFactory::load($path)->getActiveSheet()->toArray(null, true, true, true);

        $gradesFromSheet = [];
        foreach ($rows as $index => $row) {
            if ($index === 1) continue; // Skip header row

            $cne = trim($row['A']); // Column A = CNE
            $grade = isset($row['C']) && is_numeric($row['C']) ? floatval($row['C']) : null;

            if ($cne) {
                $gradesFromSheet[$cne] = $grade;
            }
        }

        // Check attendance rate
        $presentCount = 0;
        foreach ($students as $student) {
            if (array_key_exists($student->cne, $gradesFromSheet)) {
                $presentCount++;
            }
        }

        $absentPercentage = ($totalStudents - $presentCount) / $totalStudents;

        if ($absentPercentage > 0.4) {
            return back()->withErrors(['file' => 'More than 40% of students are absent. Something is wrong. Please contact an admin. (Grades not saved!)']);
        }

        foreach ($students as $student) {
            $cne = $student->cne;

            if (array_key_exists($cne, $gradesFromSheet)) {
                $grade = $gradesFromSheet[$cne];

                // Only update if the Grade already exists
                $existingGrade = Grade::where('student_id', $student->id)
                    ->where('assessment_id', $assessment->id)
                    ->first();

                if ($existingGrade) {
                    $existingGrade->grade_retake = $grade;
                    $existingGrade->save();
                }
            }
        }

        return back()->with('success', 'Retake grades updated successfully.');
    }

}
