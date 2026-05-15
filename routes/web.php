<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KoleksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Route resource untuk CRUD koleksi (7 route otomatis)
    Route::resource('koleksi', KoleksiController::class);

    // Modul 7 - Route tambahan untuk fitur AI Rekomendasi
    Route::get('/koleksi-ai', [KoleksiController::class, 'aiRekomendasi'])
         ->name('koleksi.ai');
    // ↑ GET /koleksi-ai → aiRekomendasi() = halaman rekomendasi AI
});