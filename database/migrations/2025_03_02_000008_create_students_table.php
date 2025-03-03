<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_info_id')->constrained('contacts')->onDelete('cascade');
            $table->foreignId('birth_info_id')->constrained('birth_info')->onDelete('cascade');
            $table->foreignId('bac_info_id')->constrained('baccalaureate')->onDelete('cascade');
            $table->foreignId('promotion_id')->constrained()->onDelete('cascade');
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('CNE', 20)->nullable();
            $table->string('CIN', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
