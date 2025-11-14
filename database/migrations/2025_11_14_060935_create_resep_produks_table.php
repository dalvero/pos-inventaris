<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('bahan_id')->constrained('bahan_bakus')->onDelete('cascade');
            $table->integer('jumlah'); // JUMLAH BAHAN YANG DIPAKAI
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_produks');
    }
};
