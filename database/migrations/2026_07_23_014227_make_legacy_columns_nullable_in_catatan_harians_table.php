<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catatan_harians', function (Blueprint $table) {
            $table->dateTime('waktu_pencatatan')->nullable()->change();
            $table->string('kode_material')->nullable()->change();
            $table->double('berat_anoda')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('catatan_harians', function (Blueprint $table) {
            $table->dateTime('waktu_pencatatan')->nullable(false)->change();
            $table->string('kode_material')->nullable(false)->change();
            $table->double('berat_anoda')->nullable(false)->change();
        });
    }
};