<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chg extends Model
{
    protected $fillable = ['tanggal', 'kode_material', 'berat_chg', 'berat_balldore'];
}