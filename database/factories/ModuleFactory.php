<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Module;

class ModuleFactory extends Factory
{
    protected $model = Module::class;

    public function definition(): array
    {
        return [
            'module_name' => $this->faker->word(),
            'module_description' => $this->faker->paragraph(),
            'study_program_id' => \App\Models\StudyProgram::factory(),
            'duration_hours' => $this->faker->numberBetween(20, 100),
        ];
    }
}
