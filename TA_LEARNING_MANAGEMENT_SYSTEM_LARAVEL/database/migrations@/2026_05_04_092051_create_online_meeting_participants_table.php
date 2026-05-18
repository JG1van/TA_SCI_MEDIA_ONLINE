<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('online_meeting_participants', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();

            // 🔥 Relasi (UNSIGNED wajib)
            $table->integer('online_meeting_id');
            $table->integer('user_id');

            // 🔥 Data utama
            $table->enum('role', ['teacher', 'student']);
            $table->dateTime('joined_at');
            $table->dateTime('left_at')->nullable();

            $table->timestamps();

            // 🔥 Foreign Key
            $table->foreign('online_meeting_id')
                ->references('id')
                ->on('online_meetings')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_meeting_participants');
    }
};