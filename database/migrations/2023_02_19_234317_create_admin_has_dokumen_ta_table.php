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
        Schema::create('admin_has_dokumen_ta', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id_admin');
            $table->string('dokumen_ta_id_dokumen', 15);

            $table->foreign('admin_id_admin')->references('id_admin')->on('admin');
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
        Schema::dropIfExists('admin_has_dokumen_ta');
    }
};
