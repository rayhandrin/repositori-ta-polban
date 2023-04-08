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
            $table->string('dokumen_1', 50);
            $table->string('dokumen_2', 50);
            $table->string('dokumen_3', 50);
            $table->string('dokumen_4', 50);
            $table->string('dokumen_opsional_1', 50)->nullable();
            $table->string('dokumen_opsional_2', 50)->nullable();
            $table->integer('tugas_akhir_id');

            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhir')->onDelete('NO ACTION')->onUpdate('NO ACTION');
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
