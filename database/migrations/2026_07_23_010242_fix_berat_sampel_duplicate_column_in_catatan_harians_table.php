<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catatan_harians', function (Blueprint $table) {
            // pastikan kolom asli nullable, sesuai pola field lain
            $table->decimal('berat_sampel', 12, 2)->nullable()->change();
        });

        Schema::table('catatan_harians', function (Blueprint $table) {
            if (Schema::hasColumn('catatan_harians', 'berat_sample')) {
                $table->dropColumn('berat_sample');
            }
        });
    }

    public function down(): void
    {
        Schema::table('catatan_harians', function (Blueprint $table) {
            $table->decimal('berat_sampel', 12, 2)->nullable(false)->change();
        });
    }
};
