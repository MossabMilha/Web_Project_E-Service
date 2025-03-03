<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\StudentContact;
use App\Models\StudentBirthInfo;
use App\Models\StudentBaccalaureate;
use App\Models\StudentPromotion;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'contact_info_id' => StudentContact::factory(),
            'birth_info_id' => StudentBirthInfo::factory(),
            'bac_info_id' => StudentBaccalaureate::factory(),
            'promotion_id' => StudentPromotion::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'CNE' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{8}'),
            'CIN' => $this->faker->unique()->regexify('[A-Z]{1,2}[0-9]{6}'),
        ];
    }
}
