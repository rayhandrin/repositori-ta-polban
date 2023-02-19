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
        Schema::create('kata_kunci_has_dokumen_ta', function (Blueprint $table) {
            $table->unsignedBigInteger('kata_kunci_id_kata_kunci');
            $table->string('dokumen_ta_id_dokumen', 15);

            $table->foreign('kata_kunci_id_kata_kunci')->references('id_kata_kunci')->on('kata_kunci');
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
        Schema::dropIfExists('kata_kunci_has_dokumen_ta');
    }
};
