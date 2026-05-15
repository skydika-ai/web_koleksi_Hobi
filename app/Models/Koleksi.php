<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
       // kita membuat daftar kolom yang boleh diisi lewat form
    // tanpa ini Laravel menolak semua input (proteksi keamanan)
    protected $fillable = [
        'user_id',
        'nama',
        'kategori',
        'rating',
        'status',
        'catatan',
        'gambar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // setiap koleksi DIMILIKI OLEH satu user contoh: $koleksi->user akan return data usernya
    }
    
    public function koleksis()
    {
        return $this->hasMany(Koleksi::class);  //  satu user PUNYA BANYAK koleksi contoh: $user->koleksis akan return semua koleksinya
    }
}
