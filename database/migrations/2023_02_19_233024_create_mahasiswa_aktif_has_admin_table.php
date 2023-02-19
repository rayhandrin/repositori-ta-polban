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
        Schema::create('mahasiswa_aktif_has_admin', function (Blueprint $table) {
            $table->string('mahasiswa_aktif_nim', 9);
            $table->unsignedBigInteger('admin_id_admin');

            $table->foreign('mahasiswa_aktif_nim')->references('nim')->on('mahasiswa_aktif');
            $table->foreign('admin_id_admin')->references('id_admin')->on('admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_aktif_has_admin');
    }
};
