<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DepartmentSeeder::class,
            TeachingUnitSeeder::class,
            AssignmentSeeder::class,
            WorkloadSeeder::class,
            GradeSeeder::class,
            HistorySeeder::class,
        ]);

    }
}
