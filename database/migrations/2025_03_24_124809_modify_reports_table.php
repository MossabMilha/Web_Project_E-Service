<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Drop existing foreign key if it exists
            $table->dropForeign(['generated_by']);

            // Add the foreign key again
            $table->foreign('generated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down() {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['generated_by']);
        });
    }
};
