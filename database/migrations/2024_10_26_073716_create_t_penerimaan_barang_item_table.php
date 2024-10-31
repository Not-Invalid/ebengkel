<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPenerimaanBarangItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_penerimaan_barang_item', function (Blueprint $table) {
            $table->integer('id_penerimaan_barang_item')->primary()->autoIncrement();
            $table->integer('id_penerimaan_barang');
            $table->integer('id_outlet');
            $table->integer('id_barang');
            $table->string('warna', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('qty');
            $table->integer('qty_po')->default(0);
            $table->integer('qty_open')->default(0);
            $table->integer('qty_sisa')->default(0);
            $table->integer('harga_beli')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_penerimaan_barang_item');
    }
}
