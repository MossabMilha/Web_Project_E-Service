<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department; // Import the Department model
use App\Models\User; // Import the User model


class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'head_id' => User::factory(), // Random User
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'location' => $this->faker->address,
        ];
    }
}
