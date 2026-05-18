<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('unanswered_questions', function (Blueprint $table) {
            $table->id();

            $table->text('question');                 // Pertanyaan asli user
            $table->string('keyword')->unique();     // Keyword hasil ekstraksi AI
            $table->text('solution_text')->nullable(); // Solusi yang dibuat AI

            $table->integer('count')->default(1);    // Jumlah kemunculan pertanyaan

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unanswered_questions');
    }
};