<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasir_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('toko_id')->constrained('tokos')->onDelete('cascade');
            
            $table->timestamp('opening')->nullable();
            $table->timestamp('break')->nullable();
            $table->timestamp('closing')->nullable();
            
            $table->integer('total_penjualan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
