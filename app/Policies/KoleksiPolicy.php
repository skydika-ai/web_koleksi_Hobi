<?php

namespace App\Policies;

use App\Models\Koleksi;
use App\Models\User;

class KoleksiPolicy
{
    public function view(User $user, Koleksi $koleksi): bool
    {
        return $user->id === $koleksi->user_id;
    }

    public function update(User $user, Koleksi $koleksi): bool
    {
        return $user->id === $koleksi->user_id;
    }

    public function delete(User $user, Koleksi $koleksi): bool
    {
        return $user->id === $koleksi->user_id;
    }
}