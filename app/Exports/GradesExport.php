<?php

namespace App\Exports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GradesExport implements FromCollection ,WithHeadings
{

    protected $grades;
    protected $students;
    protected $assessment;
    protected $filiere;

    public function __construct($grades, $students, $assessment, $filiere)
    {
        $this->grades = $grades;
        $this->students = $students;
        $this->assessment = $assessment;
        $this->filiere = $filiere;

    }

    // Add headings for the data table
    public function headings(): array
    {
        return [
            // First row with assessment information
            ["Assessment Information"],
            ["Name: " . $this->assessment->name],
            ["Description: " . $this->assessment->description],
            ["Semester: " . $this->assessment->semester],
            ["Filière: " . $this->filiere->name],
            ["Coordinator: " . ($this->filiere? $this->filiere->coordinator->name : 'N/A')],
            [''], // Empty row for spacing before the data table

            // Column headings for the grades table
            ['CNE', 'Full Name', 'Normal Grade', 'Retake Grade', 'Average'],
        ];
    }

    // Return the collection of student data
    public function collection()
    {
        $data = collect();

        foreach ($this->students as $student) {
            // Find the grade for the student (if exists)
            $grade = $this->grades->firstWhere('student_id', $student->id);

            // Default missing grades to 0 if no grade is found
            $normal = $grade ? $grade->grade_normal : 0;
            $retake = $grade ? $grade->grade_retake : 0;

            // If retake grade is 0, display as '-'
            $retakeDisplay = $retake != 0 ? number_format($retake, 2) : 0;

            // Calculate the average, ensure it's handled when both grades are 0
            $average = ($normal + $retake) == 0 ? 0 : (($normal + $retake) / 2);

            // Add the student's data to the collection
            $data->push([
                $student->cne,
                $student->name,
                $normal != 0 ? number_format($normal, 2) : "0",  // Display '0' for missing normal grade
                $retakeDisplay != 0 ? number_format($retakeDisplay, 2) : "0",
                $average != 0 ? number_format($average, 2) : "0",  // Display '0' for missing average
            ]);
        }

        return $data;
    }

    // Set the sheet title (you can change this if you'd like)
    public function title(): string
    {
        return 'Grades';
    }
}
