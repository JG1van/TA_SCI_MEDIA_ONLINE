<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration {
    public function up(): void
    {
        Schema::create('question_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->enum('level', ['Umum', 'Siswa', 'Guru']);
            $table->text('solution_text')->nullable();
            $table->text('guide_file')->nullable();
            $table->text('guide_video')->nullable();
            $table->enum('category_status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_categories');
    }
};
