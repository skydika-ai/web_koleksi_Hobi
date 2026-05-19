<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\AdminController;   // ← tambahkan ini
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('koleksi.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // ── Route untuk semua user (user & admin) ──
    Route::get('/koleksi-profile', [KoleksiController::class, 'profile'])
        ->name('koleksi.profile');

    Route::get('/koleksi/filter/{kategori}', [KoleksiController::class, 'filter'])
        ->name('koleksi.filter');

    Route::get('/koleksi-ai', [KoleksiController::class, 'aiRekomendasi'])
        ->name('koleksi.ai');

    Route::resource('koleksi', KoleksiController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // ── Route khusus Admin ──
    // middleware 'admin' = hanya bisa diakses kalau role === 'admin'
    // (middleware ini kita buat di langkah berikutnya)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/',                    [AdminController::class, 'index'])  ->name('index');
        // ↑ GET /admin → daftar semua user + statistik koleksi

        Route::delete('/users/{user}',     [AdminController::class, 'destroyUser'])->name('users.destroy');
        // ↑ DELETE /admin/users/{id} → hapus akun user

        Route::delete('/koleksi/{koleksi}',[AdminController::class, 'destroyKoleksi'])->name('koleksi.destroy');
        // ↑ DELETE /admin/koleksi/{id} → hapus koleksi milik siapapun
    });
});

require __DIR__.'/auth.php';