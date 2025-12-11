<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->string('qr_image')->nullable()->after('alamat');             
        });
    }

    public function down()
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->dropColumn('qr_image');
        });
    }
};
