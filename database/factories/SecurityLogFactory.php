<?php

namespace Database\Factories;

use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
class SecurityLogFactory extends Factory
{
    protected $model = SecurityLog::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Random User
            'event' => $this->faker->sentence,
            'timestamp' => $this->faker->dateTimeThisYear(),
        ];
    }
}
