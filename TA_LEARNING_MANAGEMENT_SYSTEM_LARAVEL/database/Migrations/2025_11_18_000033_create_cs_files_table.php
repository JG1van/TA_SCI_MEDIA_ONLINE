<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cs_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('room_id');
            $table->string('file_path', 255);
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('cs_rooms')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cs_files');
    }
};
