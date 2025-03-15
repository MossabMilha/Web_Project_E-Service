<?php

namespace Database\Factories;


use App\Models\User;
use App\Models\Workload;
use Illuminate\Database\Eloquent\Factories\Factory;


class WorkloadFactory extends Factory
{
    protected $model = Workload::class;

    public function definition()
    {
        return [
            'professor_id' => User::factory(), // Random Professor
            'total_hours' => $this->faker->numberBetween(10, 40),
            'minimum_required_hours' => $this->faker->numberBetween(10, 30),
        ];
    }
}
