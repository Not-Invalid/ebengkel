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
            $table->integer('id_bengkel')->nullable();
            $table->integer('id_pelanggan')->nullable();
            $table->string('nama_pegawai')->nullable();
            $table->string('telp_pegawai')->nullable();
            $table->string('email_pegawai')->nullable();
            $table->text('foto_pegawai')->nullable();
            $table->string('password_pegawai')->nullable();
            $table->enum('role', ['Administrator', 'Kasir', 'Outlet']);
            $table->timestamps();
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
