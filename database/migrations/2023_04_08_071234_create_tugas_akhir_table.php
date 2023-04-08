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
        Schema::create('tugas_akhir', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 45);
            $table->year('tahun')->nullable();
            $table->string('kata_kunci', 45)->nullable();
            $table->string('kontributor_1')->nullable();
            $table->string('kontributor_2')->nullable();
            $table->string('kontributor_3')->nullable();
            $table->timestamps();
            $table->string('admin_username');

            $table->foreign('admin_username')->references('username')->on('admin')->onDelete('NO ACTION')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas_akhir');
    }
};
