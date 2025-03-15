<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // ✅ Import Carbon

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([

            [
                'name' => 'departement head 2',
                'email' => 'departement.head2@gmail.com',
                'password' => bcrypt('departementhead123'),
                'role' => 'department_head',
                'specialization' => 'departement_head',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'departement head 3',
                'email' => 'departement.head3@gmail.com',
                'password' => bcrypt('departementhead123'),
                'role' => 'department_head',
                'specialization' => 'departement_head',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'departement head 4',
                'email' => 'departement.head4@gmail.com',
                'password' => bcrypt('departementhead123'),
                'role' => 'department_head',
                'specialization' => 'departement_head',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]

        ]);
    }
}
