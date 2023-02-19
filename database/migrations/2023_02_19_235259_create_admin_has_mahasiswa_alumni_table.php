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
        Schema::create('admin_has_mahasiswa_alumni', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id_admin');
            $table->string('mahasiswa_alumni_nim', 9);
            $table->string('mahasiswa_alumni_dokumen_ta_id_dokumen', 15);

            $table->foreign('admin_id_admin')->references('id_admin')->on('admin');
            $table->foreign('mahasiswa_alumni_nim')->references('nim')->on('mahasiswa_alumni');
            $table->foreign('mahasiswa_alumni_dokumen_ta_id_dokumen', 'ma_dta_id_dokumen_foreign')->references('dokumen_ta_id_dokumen')->on('mahasiswa_alumni');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_has_mahasiswa_alumni');
    }
};
