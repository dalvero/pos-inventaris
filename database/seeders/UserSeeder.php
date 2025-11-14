<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Toko;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // SUPER ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@pos.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'toko_id' => null
        ]);

        // ADMIN TOKO
        User::create([
            'name' => 'Admin Toko 1',
            'email' => 'admintoko1@pos.com',
            'password' => Hash::make('password123'),
            'role' => 'admin_toko',
            'toko_id' => null // NANTI UPDATE SETELAH TOKO DIBUAT
        ]);

        // Kasir sample
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir1@pos.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
            'toko_id' => null // NANTI UPDATE
        ]);
    }
}
