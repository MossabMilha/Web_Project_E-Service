<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentParentInfo;
use App\Models\Student;

class StudentParentInfoFactory extends Factory
{
    protected $model = StudentParentInfo::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'parent_phone' => $this->faker->phoneNumber(),
            'father_profession' => $this->faker->jobTitle(),
            'mother_profession' => $this->faker->jobTitle(),
            'parents_province' => $this->faker->state(),
            'parents_address' => $this->faker->address(),
        ];
    }
}
