<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            // If the column 'generated_by' exists, just add the foreign key constraint.
            $table->foreign('generated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
        });
    }
};
