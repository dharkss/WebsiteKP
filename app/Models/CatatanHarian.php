<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanHarian extends Model
{
    // Daftarkan kolom agar diizinkan masuk ke DB
    protected $fillable = [
        'tanggal_lebur',
        'no_lebur',
        'kontrak_karya',
        'tanur_pemakaian',
        'krusibel_ke',
        'jenis_material',
        'berat_material',
        'jumlah_ingot',
        'jenis_fluks',
        'berat_fluks',
        'loading_dore',
        'pouring',
        'jumlah_jam_alat',
        'completed_sof',
        'suhu',
        'berat_logam',
        'jumlah_anoda_bar_ball',
        'berat_sampel',
        'berat_slag',
    ];
}
