<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kota', function (Blueprint $table) {
            $table->integer('id_kota')->primary();
            $table->integer('id_provinsi');
            $table->string('tipe', 50);
            $table->string('kota', 100);
            $table->string('postal_code', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_kota');
    }
}
