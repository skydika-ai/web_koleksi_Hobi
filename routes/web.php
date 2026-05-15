<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KoleksiController;
// ↑ baris use harus di atas semua, setelah <?php

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
     // ↑ middleware('auth') artinya semua route di dalam sini
    //   HANYA bisa diakses oleh user yang sudah login
    //   kalau belum login, otomatis diarahkan ke halaman login

    Route::resource('koleksi', KoleksiController::class);
    // ↑ Route::resource otomatis membuat 7 route sekaligus:
    //
    //   GET    /koleksi          → index()   = halaman daftar koleksi
    //   GET    /koleksi/create   → create()  = halaman form tambah
    //   POST   /koleksi          → store()   = proses simpan data baru
    //   GET    /koleksi/{id}     → show()    = halaman detail koleksi
    //   GET    /koleksi/{id}/edit → edit()   = halaman form edit
    //   PUT    /koleksi/{id}     → update()  = proses simpan perubahan
    //   DELETE /koleksi/{id}     → destroy() = proses hapus koleksi
});