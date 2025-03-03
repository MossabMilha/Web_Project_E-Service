<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'course_name' => $this->faker->sentence(3),
            'course_description' => $this->faker->paragraph(),
            'module_id' => \App\Models\Module::factory(),
            'total_hours' => $this->faker->numberBetween(20, 100),
        ];
    }
}
