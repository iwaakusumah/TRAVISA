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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->string('name');
            $table->enum('gender', ['F', 'M']);
            $table->enum('level', ['X', 'XI']);
            $table->enum('major', ['Teknik Komputer dan Jaringan', 'Teknik Kendaraan Ringan', 'Akuntansi', 'Administrasi Perkantoran']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
