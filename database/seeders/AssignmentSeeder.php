<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assignment;

class AssignmentSeeder extends Seeder
{
    public function run()
    {
        // Seed assignments
        Assignment::factory(5)->create(); // Create 5 assignments
    }
}
