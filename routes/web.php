<?php

use App\Http\Controllers\CatatanHarianController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

// Halaman form input catatan harian (blade lama "dashboard.blade.php")
Route::view('dashboard', 'dashboard')->name('dashboard');

// Halaman laporan / analytics peleburan
Route::get('/laporan-peleburan', [CatatanHarianController::class, 'dashboard'])
    ->name('laporan-peleburan.dashboard');

// Simpan data form
Route::post('/catatan-harian', [CatatanHarianController::class, 'store'])
    ->name('catatan-harian.store');

require __DIR__.'/settings.php';
