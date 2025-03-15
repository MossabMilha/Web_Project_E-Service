<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;

class AssignmentSeeder extends Seeder
{
    public function run()
    {
        DB::table('assignments')->insert(
            [
                [
                'professor_id' => 4, // Adjust range based on existing professor IDs
                'unit_id' => 1, // Adjust based on your teaching units
                'status' => ['pending', 'approved', 'declined'][rand(0, 2)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                ],
                [
                    'professor_id' => 5, // Adjust range based on existing professor IDs
                    'unit_id' => 9, // Adjust based on your teaching units
                    'status' => ['pending', 'approved', 'declined'][rand(0, 2)],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ]
        );

    }
}
