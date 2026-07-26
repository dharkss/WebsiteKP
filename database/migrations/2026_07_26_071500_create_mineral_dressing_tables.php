<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mineral_dressing_feeds', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->decimal('total_feed', 12, 2);
            $table->timestamps();
        });

        Schema::create('chgs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kode_material');
            $table->decimal('berat_chg', 12, 2);
            $table->decimal('berat_balldore', 12, 2);
            $table->timestamps();
        });

        Schema::create('clgs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengeluaran');
            $table->string('kode_material');
            $table->decimal('berat_clg', 12, 2);
            $table->decimal('moisture_content', 8, 2);
            $table->decimal('berat_kering', 12, 2);
            $table->decimal('kadar_au', 12, 4);
            $table->decimal('kadar_ag', 12, 4);
            $table->decimal('kadar_au_reproses', 12, 4)->nullable();
            $table->decimal('kadar_ag_reproses', 12, 4)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clgs');
        Schema::dropIfExists('chgs');
        Schema::dropIfExists('mineral_dressing_feeds');
    }
};