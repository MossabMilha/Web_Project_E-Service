<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'department_name' => 'Department of Mathematics and Computer Science',
                'department_description' => 'This department offers programs focused on mathematics, algorithms, computer science, and data structures.'
            ],
            [
                'department_name' => 'Department of Civil Engineering, Energetics, and Environment',
                'department_description' => 'This department specializes in civil engineering, energy systems, and environmental sciences.'
            ],
            [
                'department_name' => 'Preparatory Cycle: Science & Technology',
                'department_description' => 'This preparatory cycle provides students with fundamental knowledge in science and engineering to prepare them for specialized study programs.',
            ]
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
