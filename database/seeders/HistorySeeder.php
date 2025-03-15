<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\History;

class HistorySeeder extends Seeder
{

    public function run()
    {
        // Use the factory to create 10 history records
        History::factory(10)->create();
    }
}
