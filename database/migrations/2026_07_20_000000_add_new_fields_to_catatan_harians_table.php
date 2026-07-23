<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catatan_harians', function (Blueprint $table) {
            if (! Schema::hasColumn('catatan_harians', 'tanggal_lebur')) {
                $table->date('tanggal_lebur')->nullable()->after('id');
            }
            if (! Schema::hasColumn('catatan_harians', 'no_lebur')) {
                $table->integer('no_lebur')->nullable()->after('tanggal_lebur');
            }
            if (! Schema::hasColumn('catatan_harians', 'tanur_pemakaian')) {
                $table->string('tanur_pemakaian')->nullable()->after('kontrak_karya');
            }
            if (! Schema::hasColumn('catatan_harians', 'krusibel_ke')) {
                $table->integer('krusibel_ke')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'jumlah_ingot')) {
                $table->integer('jumlah_ingot')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'loading_dore')) {
                $table->time('loading_dore')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'pouring')) {
                $table->time('pouring')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'jumlah_jam_alat')) {
                $table->time('jumlah_jam_alat')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'completed_sof')) {
                $table->time('completed_sof')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'suhu')) {
                $table->integer('suhu')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'berat_logam')) {
                $table->decimal('berat_logam', 12, 2)->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'jumlah_anoda_bar_ball')) {
                $table->integer('jumlah_anoda_bar_ball')->nullable();
            }
            if (! Schema::hasColumn('catatan_harians', 'berat_sample')) {
                $table->decimal('berat_sample', 12, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('catatan_harians', function (Blueprint $table) {
            $columns = [
                'tanggal_lebur', 'no_lebur', 'tanur_pemakaian', 'krusibel_ke',
                'jumlah_ingot', 'loading_dore', 'pouring', 'jumlah_jam_alat',
                'completed_sof', 'suhu', 'berat_logam', 'jumlah_anoda_bar_ball',
                'berat_sample',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('catatan_harians', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
