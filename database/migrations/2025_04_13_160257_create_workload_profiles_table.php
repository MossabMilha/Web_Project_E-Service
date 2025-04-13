<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workload_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();   // e.g., 'permanent' or 'vacataire'
            $table->float('min_hours');
            $table->float('max_hours');
            $table->timestamps(); // Optional but useful (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workload_profiles');
    }
};
