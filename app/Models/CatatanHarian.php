<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanHarian extends Model
{
    // Daftarkan kolom agar diizinkan masuk ke DB
    protected $fillable = [
        'waktu_pencatatan',
        'kontrak_karya',
        'jenis_material',
        'kode_material',
        'jenis_furnace',
        'berat_material',
        'jenis_fluks',
        'berat_fluks',
        'berat_anoda',
        'berat_slag',
        'berat_sampel',
    ];
}