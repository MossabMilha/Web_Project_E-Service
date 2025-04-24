<?php

namespace App\Exports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class GradesExport implements FromCollection, WithHeadings, WithStyles
{

    protected $grades;
    protected $students;
    protected $assessment;
    protected $filiere;
    protected $averages = [];

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
        $row = 9; // start row in Excel
        $this->averages = []; // reset

        $allRetakeFailed = true; // Flag to check if all retake grades are -1

        foreach ($this->students as $student) {
            $grade = $this->grades->firstWhere('student_id', $student->id);
            $normal = $grade ? $grade->grade_normal : -1;
            $retake = $grade ? $grade->grade_retake : -1;

            $normalDisplay = $normal != -1 ? number_format($normal, 2) : "ABS";

            // If any retake grade is not -1, update the flag
            if ($retake != -1) {
                $allRetakeFailed = false;
            }

            // Check if retake grade is -1, then add "Not Pass Yet"
            $retakeDisplay = $retake != -1 ? number_format($retake, 2) : "ABS";
            if ($retake == -1 && $allRetakeFailed) {
                $retakeDisplay = "Not Pass Yet";
            }

            // Calculate average
            if ($normal != -1 && $retake != -1) {
                $average = ($normal + $retake) / 2;
            } elseif ($normal != -1) {
                $average = $normal / 2;
            } elseif ($retake != -1) {
                $average = $retake / 2;
            } else {
                $average = -1;
            }

            $averageDisplay = $average != -1 ? number_format($average, 2) : "ABS";
            $this->averages[$row] = $average;

            $data->push([
                $student->cne,
                $student->name,
                $normalDisplay,
                $retakeDisplay,
                $averageDisplay,
            ]);

            $row++;
        }

        return $data;
    }
    public function styles(Worksheet $sheet){
        foreach ($this->averages as $row => $average) {
            if ($average != -1 && $average < 10) {
                $sheet->getStyle('E' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('b76565');
            }
        }
    }

    // Set the sheet title (you can change this if you'd like)
    public function title(): string
    {
        return 'Grades';
    }
}
