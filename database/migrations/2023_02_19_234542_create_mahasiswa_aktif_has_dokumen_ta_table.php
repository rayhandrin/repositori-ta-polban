<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_aktif_has_dokumen_ta', function (Blueprint $table) {
            $table->string('mahasiswa_aktif_nim', 9);
            $table->string('dokumen_ta_id_dokumen', 15);

            $table->foreign('mahasiswa_aktif_nim')->references('nim')->on('mahasiswa_aktif');
            $table->foreign('dokumen_ta_id_dokumen')->references('id_dokumen')->on('dokumen_ta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_aktif_has_dokumen_ta');
    }
};
