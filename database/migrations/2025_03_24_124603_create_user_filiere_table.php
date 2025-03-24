<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_filiere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_filiere');
    }
};
