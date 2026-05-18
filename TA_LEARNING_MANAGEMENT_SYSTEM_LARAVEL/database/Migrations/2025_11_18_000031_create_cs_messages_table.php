<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration {
    public function up(): void
    {
        Schema::create('cs_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cs_rooms_id');
            $table->enum('message_sender', ['Pelanggan', 'Admin', 'Sistem', 'Chatbot'])->nullable();
            $table->text('message_content')->nullable();
            $table->dateTime('sent_time')->nullable();
            $table->timestamps();

            $table->foreign('cs_rooms_id')->references('id')->on('cs_rooms')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cs_messages');
    }
};
