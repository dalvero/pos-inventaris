<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Toko;
use App\Models\User;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        // TOKO SAMPLE
        Toko::create([
            'nama_toko' => 'Toko Minuman 1',
            'alamat' => 'Jl. Contoh No.1',
            'telepon' => '08123456789',
            'user_id' => 2 // ADMIN TOKO 1
        ]);
    }
}
