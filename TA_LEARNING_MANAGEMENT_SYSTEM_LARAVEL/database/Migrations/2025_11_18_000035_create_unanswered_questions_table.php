<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel eksklusif dari Migration 1
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unanswered_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('question');
            $table->string('keyword')->unique();
            $table->text('solution_text')->nullable();
            $table->integer('count')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unanswered_questions');
    }
};
