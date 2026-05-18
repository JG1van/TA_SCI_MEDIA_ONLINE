<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('share_exercises', function (Blueprint $table) {
            $table->unsignedInteger('serial_id');
            $table->unsignedInteger('exercise_id');
            $table->timestamps();

            $table->primary(['serial_id', 'exercise_id']);
            $table->foreign('serial_id')->references('id')->on('serials')->cascadeOnDelete();
            $table->foreign('exercise_id')->references('id')->on('exercises')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('share_exercises');
    }
};
