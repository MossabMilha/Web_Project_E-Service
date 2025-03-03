<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('birth_info', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('birth_date')->nullable();
            $table->string('birth_city', 100)->nullable();
            $table->string('birth_province', 100)->nullable();
            $table->string('birth_place', 255)->nullable();
            $table->string('birth_city_ar', 100)->nullable();
            $table->string('birth_province_ar', 100)->nullable();
            $table->string('birth_place_ar', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('birth_info');
    }
};
