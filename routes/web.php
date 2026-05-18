<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KoleksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('koleksi.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/koleksi-profile', [KoleksiController::class, 'profile'])
        ->name('koleksi.profile');

    Route::get('/koleksi/filter/{kategori}', [KoleksiController::class, 'filter'])
        ->name('koleksi.filter');

    Route::resource('koleksi', KoleksiController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';