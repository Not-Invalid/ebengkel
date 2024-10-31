<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pegawai', function (Blueprint $table) {
            $table->integer('id_pegawai')->primary()->autoIncrement();
            $table->string('nama_pegawai')->nullable();
            $table->string('telp_pegawai')->nullable();
            $table->string('email_pegawai')->nullable();
            $table->text('foto_pegawai')->nullable();
            $table->string('password_pegawai')->nullable();
            $table->string('level_pegawai')->nullable();
            $table->dateTime('tgl_daftar_pegawai')->nullable();
            $table->string('delete_pegawai', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pegawai');
    }
}
