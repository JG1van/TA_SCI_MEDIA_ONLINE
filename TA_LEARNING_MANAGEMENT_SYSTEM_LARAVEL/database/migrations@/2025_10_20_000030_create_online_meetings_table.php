<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('online_meetings', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();

            // Relasi
            $table->integer('serial_id')->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->integer('classroom_id')->nullable(false);

            // Data utama
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->string('meeting_code', 50);
            $table->text('meeting_link');
            $table->string('platform', 50)->nullable(); // Zoom, Meet, Webex, dll

            // Waktu
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            // Status
            $table->enum('status', ['upcoming', 'live', 'ended', 'cancelled'])->default('upcoming');

            // Tambahan Laravel
            $table->timestamps();

            $table->foreign('serial_id')->references('id')->on('serials')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_meetings');
    }

};
