<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Seed sample users
        User::factory(10)->create(); // Create 10 users
    }
}
