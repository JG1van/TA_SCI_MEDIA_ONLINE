<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();

            // FK ke serial
            $table->integer('serial_id');

            $table->string('email_to');
            $table->string('subject');

            // jenis email
            $table->enum('email_type', [
                'Serial',
                'Peringatan',
                'Kedaluwarsa'
            ]);

            // status pengiriman
            $table->enum('status', [
                'Berhasil',
                'Gagal'
            ]);

            // sumber pengiriman
            $table->enum('source', [
                'Otomatis',
                'Login_Admin',
                'Manual'
            ]);

            $table->timestamp('created_at')->useCurrent();

            // FK
            $table->foreign('serial_id')
                ->references('id')
                ->on('serials')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};