<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_info_id' => \App\Models\StudentBirthInfo::factory(),
            'contact_info_id' => \App\Models\StudentContact::factory(),
            'department_id' => \App\Models\Department::factory(),
            'hire_date' => $this->faker->date(),
            'specialization' => $this->faker->word(),
            'contract_type' => $this->faker->randomElement(['part-time', 'permanent']),
        ];
    }
}
