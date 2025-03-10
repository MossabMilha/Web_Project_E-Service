<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['admin', 'department_head', 'coordinator', 'professor', 'vacataire']),
            'specialization' => $this->faker->optional()->word,
        ];
    }
}
