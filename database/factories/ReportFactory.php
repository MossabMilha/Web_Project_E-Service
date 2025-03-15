<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition()
    {
        return [
            'report_type' => $this->faker->word,
            'data' => json_encode(['info' => $this->faker->sentence]),
            'generated_by' => User::factory(), // Random User
        ];
    }
}
