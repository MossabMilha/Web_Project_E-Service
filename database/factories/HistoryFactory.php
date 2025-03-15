<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\History;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryFactory extends Factory
{

    protected $model = History::class;


    public function definition()
    {
        return [
            'user_id' => User::factory(),  // Use the User factory to generate a user_id
            'action' => $this->faker->sentence(),  // Generate a random action sentence
            'timestamp' => $this->faker->dateTimeThisYear(),  // Generate a random timestamp
        ];
    }
}
