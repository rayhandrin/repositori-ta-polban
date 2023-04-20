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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->string('nomor')->primary();
            $table->boolean('status')->nullable();
            $table->timestamp('direspon_pada')->nullable();
            $table->string('alasan_penolakan')->nullable();
            $table->timestamps();
            $table->string('mahasiswa_nim', 9);
            $table->string('admin_username')->nullable();

            $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswa')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('admin_username')->references('username')->on('admin')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan');
    }
};
