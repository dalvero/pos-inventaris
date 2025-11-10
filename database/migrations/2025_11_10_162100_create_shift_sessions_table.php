<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shift_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasir_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('waktu_opening')->nullable();
            $table->dateTime('waktu_break_mulai')->nullable();
            $table->dateTime('waktu_break_selesai')->nullable();
            $table->dateTime('waktu_closing')->nullable();
            $table->enum('status_shift', ['belum_mulai', 'berjalan', 'break', 'selesai'])->default('belum_mulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_sessions');
    }
};
