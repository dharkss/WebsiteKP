<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Kolom-kolom ini adalah sisa dari struktur form lama (sebelum diganti
     * dengan tanggal_lebur, no_lebur, berat_logam, dll). Karena kolomnya
     * NOT NULL tanpa default dan tidak pernah diisi lagi oleh controller,
     * insert data baru selalu gagal dengan QueryException (500 error).
     */
    public function up(): void
    {
        Schema::table('catatan_harians', function (Blueprint $table) {
            if (Schema::hasColumn('catatan_harians', 'waktu_pencatatan')) {
                $table->dropColumn('waktu_pencatatan');
            }
            if (Schema::hasColumn('catatan_harians', 'kode_material')) {
                $table->dropColumn('kode_material');
            }
            if (Schema::hasColumn('catatan_harians', 'berat_anoda')) {
                $table->dropColumn('berat_anoda');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_harians', function (Blueprint $table) {
            if (! Schema::hasColumn('catatan_harians', 'waktu_pencatatan')) {
                $table->dateTime('waktu_pencatatan')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'kode_material')) {
                $table->string('kode_material')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'berat_anoda')) {
                $table->float('berat_anoda')->nullable();
            }
        });
    }
};