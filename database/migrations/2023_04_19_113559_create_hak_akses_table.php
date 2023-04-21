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
        Schema::create('hak_akses', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->timestamp('diminta_pada');
            $table->boolean('status_disetujui')->nullable();
            $table->timestamp('akhir_peminjaman')->nullable();
            $table->string('hak_aksescol', 45);
            $table->timestamps();
            $table->string('mahasiswa_nim', 9);
            $table->string('admin_username')->nullable();
            $table->string('tugas_akhir_id', 14)->nullable();

            $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswa')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('admin_username')->references('username')->on('admin')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhir')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hak_akses');
    }
};
