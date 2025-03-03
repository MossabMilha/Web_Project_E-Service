<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudentBirthInfo;
use App\Models\StudentBaccalaureate;
use App\Models\StudentContact;
use App\Models\StudentParentInfo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 10 students with related data
        Student::factory()
            ->count(10) // This creates 10 students
            ->has(StudentBirthInfo::factory()) // Each student has birth info
            ->has(StudentBaccalaureate::factory()) // Each student has bac info
            ->has(StudentContact::factory()) // Each student has contact info
            ->has(StudentParentInfo::factory()) // Each student has parent info
            ->create();
    }
}
