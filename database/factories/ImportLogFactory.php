<?php

namespace Database\Factories;

use App\Models\ImportLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImportLogFactory extends Factory
{
    protected $model = ImportLog::class;

    public function definition()
    {
        return [
            'file_name' => $this->faker->word . '.csv',
            'status' => $this->faker->randomElement(['pending', 'success', 'failed']),
            'imported_by' => User::factory(), // Random User
        ];
    }
}
