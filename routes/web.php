<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatatanHarianController;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

// Halaman form input catatan harian
Route::view('dashboard', 'dashboard')->name('dashboard');

// Halaman laporan / analytics peleburan
Route::get('/laporan-peleburan', [CatatanHarianController::class, 'dashboard'])
    ->name('laporan-peleburan.dashboard');

// Simpan data form
Route::post('/catatan-harian', [CatatanHarianController::class, 'store'])
    ->name('catatan-harian.store');

// ==== BARU: kelola data (lihat, edit, hapus) ====
Route::get('/data-peleburan', [CatatanHarianController::class, 'index'])
    ->name('data-peleburan.index');

Route::get('/data-peleburan/{catatanHarian}/edit', [CatatanHarianController::class, 'edit'])
    ->name('data-peleburan.edit');

Route::put('/data-peleburan/{catatanHarian}', [CatatanHarianController::class, 'update'])
    ->name('data-peleburan.update');

Route::delete('/data-peleburan/{catatanHarian}', [CatatanHarianController::class, 'destroy'])
    ->name('data-peleburan.destroy');

require __DIR__.'/settings.php';