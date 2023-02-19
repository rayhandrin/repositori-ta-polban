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
        Schema::create('mahasiswa_alumni', function (Blueprint $table) {
            $table->string('nim', 9)->unique()->primary();
            $table->string('nama', 50);
            $table->string('jurusan', 50);
            $table->string('program_studi', 70);
            $table->year('angkatan');
            $table->string('document_file_path');
            $table->string('dokumen_ta_id_dokumen', 15);
            $table->timestamps();

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
        Schema::dropIfExists('mahasiswa_alumni');
    }
};
