<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Koleksi;
use App\Models\User;

class KoleksiSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 user contoh dulu
        $user = User::create([
            'name'     => 'Andika',
            'email'    => 'andika@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        // ↑ bcrypt() mengenkripsi password agar tidak tersimpan polos di database

        // Isi koleksi contoh milik user tersebut
        $koleksis = [
            [
                'nama'     => 'Elden Ring',
                'kategori' => 'game',
                'rating'   => 5,
                'status'   => 'dimiliki',
                'catatan'  => 'Game terbaik yang pernah saya mainkan',
                'gambar'   => null,
            ],
            [
                'nama'     => 'Hollow Knight',
                'kategori' => 'game',
                'rating'   => 4,
                'status'   => 'dimiliki',
                'catatan'  => 'Platformer indie yang sangat bagus',
                'gambar'   => null,
            ],
            [
                'nama'     => 'Atomic Habits',
                'kategori' => 'buku',
                'rating'   => 5,
                'status'   => 'dimiliki',
                'catatan'  => 'Buku wajib baca tentang kebiasaan',
                'gambar'   => null,
            ],
            [
                'nama'     => 'The Alchemist',
                'kategori' => 'buku',
                'rating'   => 4,
                'status'   => 'wishlist',
                'catatan'  => 'Ingin beli bulan depan',
                'gambar'   => null,
            ],
            [
                'nama'     => 'Interstellar',
                'kategori' => 'film',
                'rating'   => 5,
                'status'   => 'dimiliki',
                'catatan'  => 'Film sci-fi terbaik sepanjang masa',
                'gambar'   => null,
            ],
            [
                'nama'     => 'Dune Part Two',
                'kategori' => 'film',
                'rating'   => 4,
                'status'   => 'wishlist',
                'catatan'  => 'Belum sempat nonton',
                'gambar'   => null,
            ],
        ];

        // Loop dan simpan satu per satu ke database
        foreach ($koleksis as $item) {
            Koleksi::create([
                'user_id'  => $user->id,
                // ↑ hubungkan koleksi ke user yang baru dibuat
                'nama'     => $item['nama'],
                'kategori' => $item['kategori'],
                'rating'   => $item['rating'],
                'status'   => $item['status'],
                'catatan'  => $item['catatan'],
                'gambar'   => $item['gambar'],
            ]);
        }
    }
}