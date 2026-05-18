<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cs_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('room_code', 50)->unique();

            $table->integer('question_categories_id')->nullable();
            $table->integer('admin_id')->nullable();

            $table->dateTime('completion_time');
            $table->enum('resolution_by', ['QnA', 'ChatBot', 'Admin']);

            $table->integer('rating'); // wajib
            $table->text('review')->nullable();    // opsional

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('admin_id')
                ->references('id')->on('admins')
                ->onDelete('set null');

            $table->foreign('question_categories_id')
                ->references('id')->on('question_categories')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cs_logs');
    }

};
