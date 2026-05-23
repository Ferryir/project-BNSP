<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Membuat akun admin default jika belum ada.
     */
    public function run()
    {
        // Buat akun admin default jika belum ada
        User::firstOrCreate(
            ['email' => 'admin@projectbnsp.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );
    }
}
