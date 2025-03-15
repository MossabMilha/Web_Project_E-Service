<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeachingUnit;

class TeachingUnitSeeder extends Seeder
{
    public function run()
    {
        // Seed teaching units
        TeachingUnit::factory(10)->create(); // Create 10 teaching units
    }
}
