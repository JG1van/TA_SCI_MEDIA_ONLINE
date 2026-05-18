<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('serial_id');
            $table->string('email_to');
            $table->string('subject');
            $table->enum('email_type', ['Serial', 'Peringatan', 'Kedaluwarsa']);
            $table->enum('status', ['Berhasil', 'Gagal']);
            $table->enum('source', ['Otomatis', 'Login_Admin', 'Manual']);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('serial_id')->references('id')->on('serials')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
