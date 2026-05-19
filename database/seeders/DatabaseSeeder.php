<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(KoleksiSeeder::class);

        // Akun admin — login dengan kredensial ini pertama kali
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin Dika',
                'password' => bcrypt('admin123'),
                'role'     => 'admin',
                // ↑ satu-satunya cara membuat admin adalah lewat seeder ini
                //   atau ubah langsung di database
            ]
        );
        // firstOrCreate → kalau email sudah ada, skip (tidak duplikat)

        // Akun user biasa untuk testing
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'     => 'Test User',
                'password' => bcrypt('password'),
                'role'     => 'user',
            ]
        );
    }
}