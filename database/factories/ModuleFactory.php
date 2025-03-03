<?php

namespace Database\Factories;

use App\Models\StudyProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_name' => $this->faker->word(),
            'module_description' => $this->faker->sentence(),
            'study_program_id' => StudyProgram::inRandomOrder()->first()->id,
            'duration_hours ' => $this->faker->randomDigit(),
        ];
    }
}
