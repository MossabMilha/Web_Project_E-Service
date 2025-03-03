<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudyProgram;

class StudyProgramFactory extends Factory
{
    protected $model = StudyProgram::class;

    public function definition(): array
    {
        return [
            'department_id' => \App\Models\Department::factory(),
            'program_name' => $this->faker->sentence(3),
            'program_description' => $this->faker->paragraph(),
        ];
    }
}
