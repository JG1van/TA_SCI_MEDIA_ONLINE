<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mapel_id');
            $table->string('name', 50);
            $table->string('grade', 10);
            $table->tinyInteger('semester'); // M1: integer → M2: tinyInteger
            $table->tinyInteger('category')->default(1); // M1: integer → M2: tinyInteger
            $table->timestamps();

            $table->foreign('mapel_id')->references('id')->on('mapels')->cascadeOnDelete();
            $table->index(['mapel_id', 'grade']); // dari M2
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
