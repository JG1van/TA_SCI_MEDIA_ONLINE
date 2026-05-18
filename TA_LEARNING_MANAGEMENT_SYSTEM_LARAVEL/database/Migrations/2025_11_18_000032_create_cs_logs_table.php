<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cs_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('room_code', 50)->unique();
            $table->unsignedInteger('question_categories_id')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
            $table->dateTime('completion_time');
            $table->enum('resolution_by', ['QnA', 'ChatBot', 'Admin']);
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->nullOnDelete();
            $table->foreign('question_categories_id')->references('id')->on('question_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cs_logs');
    }
};
