<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('serial_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('serial_id');
            $table->string('active', 3);
            $table->enum('status', ['Baru', 'Perpanjang'])->default('Baru');
            $table->timestamps();

            $table->foreign('serial_id')->references('id')->on('serials')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('serial_logs');
    }
};
