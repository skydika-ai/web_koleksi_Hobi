<?php

namespace App\Policies;

use App\Models\Koleksi;
use App\Models\User;

class KoleksiPolicy
{
    // ─────────────────────────────────────────────────────────
    // before() dipanggil SEBELUM method lain di policy ini.
    // Kalau return true → langsung diizinkan tanpa cek lebih lanjut.
    // Kalau return null → lanjut ke method yang sesuai (view/update/delete).
    // ─────────────────────────────────────────────────────────
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;  // admin selalu diizinkan untuk semua aksi
        }

        return null;  // bukan admin → lanjut ke pengecekan di bawah
    }

    // User biasa hanya boleh lihat koleksi miliknya sendiri
    public function view(User $user, Koleksi $koleksi): bool
    {
        return $user->id === $koleksi->user_id;
    }

    // User biasa hanya boleh edit koleksi miliknya sendiri
    public function update(User $user, Koleksi $koleksi): bool
    {
        return $user->id === $koleksi->user_id;
    }

    // User biasa hanya boleh hapus koleksi miliknya sendiri
    public function delete(User $user, Koleksi $koleksi): bool
    {
        return $user->id === $koleksi->user_id;
    }
}