<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clg extends Model
{
    protected $fillable = [
        'tanggal_pengeluaran',
        'kode_material',
        'berat_clg',
        'moisture_content',
        'berat_kering',
        'kadar_au',
        'kadar_ag',
        'kadar_au_reproses',
        'kadar_ag_reproses',
    ];
}