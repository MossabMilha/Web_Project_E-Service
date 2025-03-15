<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        // Seed departments
        Department::factory(5)->create(); // Create 5 departments
    }
}
