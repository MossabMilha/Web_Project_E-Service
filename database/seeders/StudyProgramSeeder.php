<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studyPrograms = [
            ['department_id' => 1, 'program_name' => 'Computer Engineering', 'program_description' => 'Program focused on software, hardware, and computer systems.'],
            ['department_id' => 2, 'program_name' => 'Civil Engineering', 'program_description' => 'Program focusing on the design, construction, and maintenance of infrastructure.'],
            ['department_id' => 2, 'program_name' => 'Environmental Engineering', 'program_description' => 'Program concentrating on solving environmental issues through engineering solutions.'],
            ['department_id' => 2, 'program_name' => 'Energies and Renewable Energies Engineering', 'program_description' => 'Program dedicated to the study of sustainable energy sources and technology.'],
            ['department_id' => 1, 'program_name' => 'Data Engineering', 'program_description' => 'Program focused on managing and analyzing large data sets for various applications.'],
            ['department_id' => 2, 'program_name' => 'Mechanical Engineering', 'program_description' => 'Program focusing on the design, analysis, and manufacturing of mechanical systems.'],
            ['department_id' => 1, 'program_name' => 'Digital Transformation and Artificial Intelligence', 'program_description' => 'Program focusing on digital transformation, automation, and AI solutions.'],
            ['department_id' => 3, 'program_name' => 'Preparatory Cycle Year 1', 'program_description' => 'First year of the preparatory cycle focusing on fundamental sciences and technical knowledge.'],
            ['department_id' => 3, 'program_name' => 'Preparatory Cycle Year 2', 'program_description' => 'Second year of the preparatory cycle, building on CP1 with advanced scientific and engineering concepts.']
        ];

        foreach ($studyPrograms as $program) {
            StudyProgram::create($program);
        }
    }
}
