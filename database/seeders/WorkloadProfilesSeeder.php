<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\WorkloadProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkloadProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkloadProfile::insert([
            [
                'type' => 'permanent',
                'min_hours' => 64,
                'max_hours' => 96,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type' => 'vacataire',
                'min_hours' => 0,
                'max_hours' => 48,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
