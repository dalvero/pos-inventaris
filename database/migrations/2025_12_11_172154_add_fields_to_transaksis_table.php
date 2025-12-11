<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('kode_transaksi')->unique()->after('kasir_id');
            $table->enum('metode_pembayaran', ['cash', 'qris'])->after('total_harga');
            $table->integer('uang_diterima')->nullable()->after('metode_pembayaran');
            $table->integer('kembalian')->nullable()->after('uang_diterima');
            $table->enum('status', ['paid', 'unpaid', 'failed'])->default('paid')->after('kembalian');
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn([
                'kode_transaksi',
                'metode_pembayaran',
                'uang_diterima',
                'kembalian',
                'status'
            ]);
        });
    }

};
