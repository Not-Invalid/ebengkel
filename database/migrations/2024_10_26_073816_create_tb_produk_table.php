<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_produk', function (Blueprint $table) {
            $table->increments('id_produk')->autoIncrement();
            $table->integer('id_bengkel')->nullable();
            $table->unsignedBigInteger('id_kategori_spare_part')->nullable();
            $table->string('kualitas_produk')->nullable();
            $table->string('merk_produk')->nullable();
            $table->string('nama_produk')->nullable();
            $table->integer('harga_produk')->nullable();
            $table->text('keterangan_produk')->nullable();
            $table->text('foto_produk')->nullable();
            $table->integer('stok_produk')->nullable();
            $table->dateTime('create_produk')->nullable();
            $table->string('delete_produk', 1)->default('N');
            $table->foreign('id_kategori_spare_part')->references('id_kategori_spare_part')->on('tb_kategori_spare_part')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_produk');
    }
}
