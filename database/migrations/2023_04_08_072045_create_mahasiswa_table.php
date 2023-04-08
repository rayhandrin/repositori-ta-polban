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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->integer('nim')->primary();
            $table->string('nama');
            $table->string('program_studi', 70);
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->boolean('status_aktif')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('tugas_akhir_id')->nullable();

            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhir')->onDelete('SET NULL')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
};
