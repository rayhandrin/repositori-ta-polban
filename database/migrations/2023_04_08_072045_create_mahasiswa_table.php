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
            $table->string('nim', 9)->primary();
            $table->string('nama');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('status_aktif');
            $table->timestamps();
            $table->string('tugas_akhir_id', 14)->nullable();
            $table->string('program_studi_nomor', 4)->nullable();

            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhir')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('program_studi_nomor')->references('nomor')->on('program_studi')->onDelete('SET NULL')->onUpdate('CASCADE');
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
