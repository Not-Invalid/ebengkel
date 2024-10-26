<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbLogPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_log_pegawai', function (Blueprint $table) {
            $table->integer('id_log_pegawai')->primary();
            $table->integer('id_pegawai')->nullable();
            $table->dateTime('tgl_log_pegawai')->nullable();
            $table->string('delete_log_pegawai', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_log_pegawai');
    }
}
