<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        DB::table('departments')->insert([
            [
                'name' => 'Computer Science',
                'description' => 'Computer Science Department',
                'head_id' => 3,
                'email' => 'departement.head@gmail.com',
                'phone' => '08123456789',
                'location' => 'ENSAH',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Data Science',
                'description' => 'Data Science Department',
                'head_id' => 6,
                'email' => 'departement.head2@gmail.com',
                'phone' => '08123456789',
                'location' => 'ENSAH',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Civil Engineering',
                'description' => 'Civil Engineering Department',
                'head_id' => 7,
                'email' => 'departement.head3@gmail.com',
                'phone' => '08123456789',
                'location' => 'ENSAH',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Artificial Intelligence',
                'description' => 'Artificial Intelligence Department',
                'head_id' => 8,
                'email' => 'departement.head4@gmail.com',
                'phone' => '08123456789',
                'location' => 'ENSAH',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],


    ]);

    }
}
