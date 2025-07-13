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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->float('leaving_flow'); // hasil Net Flow PROMETHEE
            $table->float('entering_flow'); // hasil Net Flow PROMETHEE
            $table->float('net_flow'); // hasil Net Flow PROMETHEE
            $table->integer('rank');    // peringkat dalam satu kelompok kelas
            $table->timestamps();

            $table->unique(['student_id', 'period_id'], 'unique_student_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
