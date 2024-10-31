<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kota', function (Blueprint $table) {
            $table->integer('id_kota')->primary()->autoIncrement();
            $table->integer('id_provinsi')->nullable();
            $table->string('nama_kota')->nullable();
            $table->string('delete_kota', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_kota');
    }
}
