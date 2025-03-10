<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        // Create 10 random users and insert them into the database
        User::factory()->count(1)->create();
    }
}
