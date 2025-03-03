<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentContact;

class StudentContactFactory extends Factory
{
    protected $model = StudentContact::class;

    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'institutional_email' => $this->faker->safeEmail(),
        ];
    }
}
