<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition()
    {
        return [
            'professor_id' => User::factory(), // Random Professor
            'unit_id' => TeachingUnit::factory(), // Random TeachingUnit
            'status' => $this->faker->randomElement(['pending', 'approved', 'declined']),
        ];
    }
}
