<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\TeachingUnit;
use Illuminate\Support\Facades\DB;

class TeachingUnitSeeder extends Seeder
{
    public function run()
    {
        DB::table('teaching_units')->insert(
            [
                // Computer Science
                [
                    'name' => 'Introduction to Programming',
                    'description' => 'Basic programming concepts using Python.',
                    'department_id' => 1,
                    'hours' => 60,
                    'credits' => 6,
                    'semester' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Algorithms and Data Structures',
                    'description' => 'Fundamentals of algorithms and data structures.',
                    'department_id' => 1,
                    'hours' => 50,
                    'credits' => 5,
                    'semester' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Operating Systems',
                    'description' => 'Concepts of OS, process management, and memory.',
                    'department_id' => 1,
                    'hours' => 45,
                    'credits' => 5,
                    'semester' => 3,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Computer Networks',
                    'description' => 'Introduction to networking and protocols.',
                    'department_id' => 1,
                    'hours' => 40,
                    'credits' => 4,
                    'semester' => 4,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],

                // Data Science
                [
                    'name' => 'Statistics for Data Science',
                    'description' => 'Fundamentals of statistics in data science.',
                    'department_id' => 2,
                    'hours' => 50,
                    'credits' => 5,
                    'semester' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Machine Learning Basics',
                    'description' => 'Introduction to machine learning algorithms.',
                    'department_id' => 2,
                    'hours' => 45,
                    'credits' => 5,
                    'semester' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Big Data Technologies',
                    'description' => 'Processing and analyzing large datasets.',
                    'department_id' => 2,
                    'hours' => 50,
                    'credits' => 5,
                    'semester' => 3,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Deep Learning',
                    'description' => 'Advanced deep learning techniques.',
                    'department_id' => 2,
                    'hours' => 40,
                    'credits' => 5,
                    'semester' => 4,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],

                // Civil Engineering
                [
                    'name' => 'Structural Engineering',
                    'description' => 'Principles of structural analysis.',
                    'department_id' => 3,
                    'hours' => 50,
                    'credits' => 4,
                    'semester' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Construction Materials',
                    'description' => 'Study of materials used in construction.',
                    'department_id' => 3,
                    'hours' => 45,
                    'credits' => 4,
                    'semester' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Hydraulics and Fluid Mechanics',
                    'description' => 'Fluid dynamics and hydraulic engineering.',
                    'department_id' => 3,
                    'hours' => 50,
                    'credits' => 5,
                    'semester' => 3,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Transportation Engineering',
                    'description' => 'Planning and design of transportation systems.',
                    'department_id' => 3,
                    'hours' => 40,
                    'credits' => 4,
                    'semester' => 4,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],

                // Artificial Intelligence
                [
                    'name' => 'AI Fundamentals',
                    'description' => 'Basic concepts and applications of AI.',
                    'department_id' => 4,
                    'hours' => 50,
                    'credits' => 5,
                    'semester' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Natural Language Processing',
                    'description' => 'Processing and understanding human language.',
                    'department_id' => 4,
                    'hours' => 45,
                    'credits' => 5,
                    'semester' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Computer Vision',
                    'description' => 'Understanding images and videos using AI.',
                    'department_id' => 4,
                    'hours' => 50,
                    'credits' => 5,
                    'semester' => 3,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Reinforcement Learning',
                    'description' => 'Decision-making using reinforcement learning.',
                    'department_id' => 4,
                    'hours' => 40,
                    'credits' => 4,
                    'semester' => 4,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]

        );
    }
}
