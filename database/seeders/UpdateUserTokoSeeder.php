<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Toko;
use App\Models\User;

class UpdateUserTokoSeeder extends Seeder
{
    public function run(): void
    {
        $toko = Toko::first();

        // Update Admin Toko
        $adminToko = User::where('role', 'admin_toko')->first();
        $adminToko->update(['toko_id' => $toko->id]);

        // Update Kasir
        $kasir = User::where('role', 'kasir')->first();
        $kasir->update(['toko_id' => $toko->id]);
    }
}
