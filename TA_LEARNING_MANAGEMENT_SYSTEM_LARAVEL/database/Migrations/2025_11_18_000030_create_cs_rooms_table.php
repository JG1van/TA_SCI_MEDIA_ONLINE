<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cs_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('room_code', 50)->unique();
            $table->unsignedInteger('question_categories_id')->nullable();
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
            $table->enum('chat_status', ['QnA', 'ChatBot', 'Admin'])->default('QnA');
            $table->timestamps();

            $table->foreign('question_categories_id')->references('id')->on('question_categories')->nullOnDelete();
            $table->foreign('student_id')->references('id')->on('students')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('admin_id')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cs_rooms');
    }
};
