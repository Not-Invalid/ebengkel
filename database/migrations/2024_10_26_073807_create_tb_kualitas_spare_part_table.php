<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKualitasSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kualitas_spare_part', function (Blueprint $table) {
            $table->integer('id_kualitas_spare_part')->primary();
            $table->string('nama_kualitas_spare_part')->nullable();
            $table->string('delete_kualitas_spare_part', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_kualitas_spare_part');
    }
}
