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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->string('dokumen_1');
            $table->string('dokumen_2');
            $table->string('dokumen_3');
            $table->string('dokumen_4');
            $table->string('dokumen_opsional_1')->nullable();
            $table->string('dokumen_opsional_2')->nullable();
            $table->string('tugas_akhir_id', 14);

            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhir')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen');
    }
};
