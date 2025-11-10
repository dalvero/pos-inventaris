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
        Schema::create('material_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_id')->constrained('materials')->onDelete('cascade');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->decimal('jumlah', 12, 2);
            $table->string('alasan')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('cascade');
            $table->dateTime('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_logs');
    }
};
