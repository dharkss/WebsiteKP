<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatatanHarianController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // Halaman form input catatan harian (blade lama "dashboard.blade.php")
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Halaman laporan / analytics peleburan
    // Ini yang dicari oleh route('laporan-peleburan.dashboard') di layout
    Route::get('/laporan-peleburan', [CatatanHarianController::class, 'dashboard'])
        ->name('laporan-peleburan.dashboard');

    // Simpan data form
    Route::post('/catatan-harian', [CatatanHarianController::class, 'store'])
        ->name('catatan-harian.store');
});

require __DIR__.'/settings.php';