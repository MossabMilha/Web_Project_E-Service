<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\User;
use App\Models\TeachingUnit;
use Illuminate\Database\Eloquent\Factories\Factory;


class GradeFactory extends Factory
{
    protected $model = Grade::class;

    public function definition()
    {
        return [
            'student_id' => User::factory(), // Random Student
            'unit_id' => TeachingUnit::factory(), // Random TeachingUnit
            'professor_id' => User::factory(), // Random Professor
            'grade_normal' => $this->faker->optional()->randomFloat(2, 0, 20),
            'grade_retake' => $this->faker->optional()->randomFloat(2, 0, 20),
        ];
    }
}
