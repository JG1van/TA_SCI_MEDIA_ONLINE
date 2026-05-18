<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('serials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('product_id');
            $table->string('serial', 50)->unique(); // M1 ada unique, dipertahankan untuk integritas data
            $table->string('paket', 1);
            $table->string('active', 3);
            $table->timestamp('expired_at')->nullable();
            // kolom notif dari M1 dipertahankan agar user M1 tidak error
            $table->enum('notif', ['Tidak_ada', 'Peringatan', 'Kedaluwarsa'])->default('Tidak_ada');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete(); // M2: nullOnDelete
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('serials');
    }
};
