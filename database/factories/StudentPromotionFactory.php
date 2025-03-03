<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentPromotion;

class StudentPromotionFactory extends Factory
{
    protected $model = StudentPromotion::class;

    public function definition(): array
    {
        return [
            'study_program_id' => \App\Models\StudyProgram::factory(),
            'academic_year' => $this->faker->year() . '-' . ($this->faker->year() + 1),
        ];
    }
}
