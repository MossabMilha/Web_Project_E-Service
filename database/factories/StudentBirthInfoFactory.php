<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentBirthInfo;

class StudentBirthInfoFactory extends Factory
{
    protected $model = StudentBirthInfo::class;

    public function definition(): array
    {
        return [
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'birth_date' => $this->faker->date(),
            'birth_city' => $this->faker->city(),
            'birth_province' => $this->faker->state(),
            'birth_place' => $this->faker->address(),
            'birth_city_ar' => $this->faker->city(),
            'birth_province_ar' => $this->faker->state(),
            'birth_place_ar' => $this->faker->address(),
        ];
    }
}
