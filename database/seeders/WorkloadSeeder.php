<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Workload;
use Illuminate\Support\Facades\DB;

class WorkloadSeeder extends Seeder
{
    public function run()
    {
        DB::table('workloads')->insert([

            [
                'professor_id' => 4, // Adjust based on existing professors
                'total_hours' => 40,
                'minimum_required_hours' => 70,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'professor_id' => 5, // Adjust based on existing professors
                'total_hours' => 20,
                'minimum_required_hours' => 65,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
