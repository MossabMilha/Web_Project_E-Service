<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'department_name' => 'Department of Mathematics and Computer Science',
                'department_description' => 'This department offers programs focused on mathematics, algorithms, computer science, and data structures.'
            ],
            [
                'department_name' => 'Department of Civil Engineering, Energetics, and Environment',
                'department_description' => 'This department specializes in civil engineering, energy systems, and environmental sciences.'
            ],

        ];
    }
}
