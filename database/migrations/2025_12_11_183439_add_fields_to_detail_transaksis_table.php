<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->integer('harga_satuan')->nullable()->after('produk_id');
        });
    }
    
    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
             $table->dropColumn('harga_satuan');
        });
    }
};
