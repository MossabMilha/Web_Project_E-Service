<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentBaccalaureate;

class StudentBaccalaureateFactory extends Factory
{
    protected $model = StudentBaccalaureate::class;

    public function definition(): array
    {
        return [
            'bac_year' => $this->faker->year(),
            'bac_type' => $this->faker->randomElement(['Science', 'Math', 'Arts']),
            'bac_mention' => $this->faker->randomElement(['Assez Bien', 'Bien', 'Très Bien', 'Excellent']),
            'bac_origin' => $this->faker->city(),
            'academy' => $this->faker->company(),
            'high_school' => $this->faker->company(),
            'high_school_type' => $this->faker->randomElement(['Public', 'Private', 'International', 'Vocational']),
        ];
    }
}
