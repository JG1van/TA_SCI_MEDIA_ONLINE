<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('serial_id');
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('student_id');
            $table->text('description');
            $table->text('attachment')->nullable();
            $table->string('point', 3)->nullable();
            $table->timestamps();
            $table->softDeletes(); // dari M2

            $table->foreign('serial_id')->references('id')->on('serials')->cascadeOnDelete();
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
            $table->index(['student_id', 'post_id']); // dari M2
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
