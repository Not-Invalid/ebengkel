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
            $table->integer('id_kategori_produk')->nullable();
            $table->integer('id_kualitas_produk')->nullable();
            $table->integer('id_merk_produk')->nullable();
            $table->string('id_merk_produk1')->nullable();
            $table->string('nama_produk')->nullable();
            $table->integer('harga_produk')->nullable();
            $table->text('keterangan_produk')->nullable();
            $table->text('foto_produk')->nullable();
            $table->integer('stok_produk')->nullable();
            $table->dateTime('create_produk')->nullable();
            $table->string('delete_produk', 1)->default('N');
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
