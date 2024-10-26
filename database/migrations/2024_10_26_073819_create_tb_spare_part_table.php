<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_spare_part', function (Blueprint $table) {
            $table->integer('id_spare_part')->primary();
            $table->integer('id_bengkel')->nullable();
            $table->integer('id_jenis_spare_part')->nullable();
            $table->integer('id_kategori_spare_part')->nullable();
            $table->integer('id_kualitas_spare_part')->nullable();
            $table->integer('id_merk_spare_part')->nullable();
            $table->string('nama_spare_part')->nullable();
            $table->integer('harga_spare_part')->nullable();
            $table->text('keterangan_spare_part')->nullable();
            $table->text('foto_spare_part')->nullable();
            $table->integer('stok_spare_part')->nullable();
            $table->string('delete_spare_part', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_spare_part');
    }
}
