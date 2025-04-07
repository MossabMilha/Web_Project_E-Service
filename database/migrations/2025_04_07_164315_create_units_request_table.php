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
        Schema::create('units_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('teaching_units')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->integer('semester'); // 1 to 5
            $table->string('academic_year', 9); // e.g., '2024-2025'

            $table->timestamp('requested_at');
            $table->timestamp('reviewed_at')->nullable();

            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units_request');
    }
};
