<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('baccalaureate', function (Blueprint $table) {
            $table->id();
            $table->year('bac_year')->nullable();
            $table->string('bac_type', 50)->nullable();
            $table->enum('bac_mention', ['Assez Bien', 'Bien', 'Très Bien', 'Excellent']);
            $table->string('bac_origin', 255)->nullable();
            $table->string('academy', 255)->nullable();
            $table->string('high_school', 255)->nullable();
            $table->enum('high_school_type', ['Public', 'Private', 'International', 'Vocational']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baccalaureate');
    }
};
