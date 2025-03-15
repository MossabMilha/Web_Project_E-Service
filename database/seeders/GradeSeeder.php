<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run()
    {
        // Seed grades
        Grade::factory(10)->create(); // Create 10 grade records
    }
}
