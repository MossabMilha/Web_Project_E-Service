<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateAllTables extends Command
{
    protected $signature = 'db:truncate-all';
    protected $description = 'Truncate all tables in the database';

    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Get the list of all tables
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_" . env('DB_DATABASE')};
            DB::table($tableName)->truncate();
            $this->info("Table $tableName truncated successfully.");
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
