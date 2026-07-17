<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catatan_harians', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu_pencatatan');
            $table->string('kontrak_karya')->nullable();
            $table->string('jenis_material')->nullable();
            $table->string('kode_material');
            $table->string('jenis_furnace')->nullable();
            $table->float('berat_material');
            $table->string('jenis_fluks')->nullable();
            $table->float('berat_fluks');
            $table->float('berat_anoda');
            $table->float('berat_slag');
            $table->float('berat_sampel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_harians');
    }
};
