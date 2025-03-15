<?php

namespace Database\Factories;

use App\Models\TeachingUnit;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;


class TeachingUnitFactory extends Factory
{
    protected $model = TeachingUnit::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'department_id' => Department::factory(), // Random Department
            'hours' => $this->faker->numberBetween(10, 40),
            'credits' => $this->faker->numberBetween(3, 6),
            'semester' => $this->faker->numberBetween(1, 2),
        ];
    }
}
