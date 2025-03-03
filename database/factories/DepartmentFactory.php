<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'department_name' => $this->faker->word(),
            'department_description' => $this->faker->paragraph(),
        ];
    }
}
