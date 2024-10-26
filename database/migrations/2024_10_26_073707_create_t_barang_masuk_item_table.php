<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBarangMasukItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_barang_masuk_item', function (Blueprint $table) {
            $table->integer('id_barang_masuk_item')->primary();
            $table->integer('id_barang_masuk');
            $table->integer('id_outlet');
            $table->integer('id_barang');
            $table->string('warna', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('qty');
            $table->integer('harga_beli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_barang_masuk_item');
    }
}
