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

use App\Http\Controllers\MineralDressingController;

// Mineral Dressing - Input Feed
Route::get('/mineral-dressing/input-feed', [MineralDressingController::class, 'createInputFeed'])
    ->name('mineral-dressing.input-feed');
Route::post('/mineral-dressing/input-feed', [MineralDressingController::class, 'storeInputFeed'])
    ->name('mineral-dressing.input-feed.store');

// Mineral Dressing - CHG
Route::get('/mineral-dressing/chg', [MineralDressingController::class, 'createChg'])
    ->name('mineral-dressing.chg');
Route::post('/mineral-dressing/chg', [MineralDressingController::class, 'storeChg'])
    ->name('mineral-dressing.chg.store');

// Mineral Dressing - CLG
Route::get('/mineral-dressing/clg', [MineralDressingController::class, 'createClg'])
    ->name('mineral-dressing.clg');
Route::post('/mineral-dressing/clg', [MineralDressingController::class, 'storeClg'])
    ->name('mineral-dressing.clg.store');
    
require __DIR__.'/settings.php';