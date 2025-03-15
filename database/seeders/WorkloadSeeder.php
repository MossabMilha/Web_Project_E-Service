<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workload;

class WorkloadSeeder extends Seeder
{
    public function run()
    {
        // Seed workloads
        Workload::factory(5)->create(); // Create 5 workloads
    }
}
