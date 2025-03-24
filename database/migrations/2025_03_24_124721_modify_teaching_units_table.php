<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('teaching_units', function (Blueprint $table) {
            // Check if column already exists before adding it
            if (!Schema::hasColumn('teaching_units', 'filiere_id')) {
                $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('teaching_units', function (Blueprint $table) {
            $table->dropForeign(['filiere_id']);
        });
    }
};
