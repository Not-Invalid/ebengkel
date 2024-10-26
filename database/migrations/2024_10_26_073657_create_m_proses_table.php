<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_proses', function (Blueprint $table) {
            $table->integer('id_proses')->primary();
            $table->string('nama_proses', 500);
            $table->string('keterangan', 1000);
            $table->string('is_delete', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_proses');
    }
}
