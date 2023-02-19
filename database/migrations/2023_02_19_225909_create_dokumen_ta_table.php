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
        Schema::create('dokumen_ta', function (Blueprint $table) {
            $table->string('id_dokumen', 15)->unique()->primary();
            $table->string('judul');
            $table->string('jurusan', 50);
            $table->string('program_studi', 70);
            $table->year('tahun');
            $table->string('staf_perpus_input', 50);
            $table->string('document_file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen_ta');
    }
};
