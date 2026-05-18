<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'kategori',
        'rating',
        'status',
        'catatan',
        'gambar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}