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
        Schema::create('mahasiswa_aktif', function (Blueprint $table) {
            $table->string('nim', 9)->unique()->primary();
            $table->string('nama', 50);
            $table->string('jurusan', 50);
            $table->string('program_studi', 70);
            $table->year('angkatan');
            $table->string('email', 50)->unique();
            $table->string('password', 100);
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
        Schema::dropIfExists('mahasiswa_aktif');
    }
};
