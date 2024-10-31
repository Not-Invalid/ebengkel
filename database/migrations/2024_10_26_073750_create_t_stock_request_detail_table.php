<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTStockRequestDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_stock_request_detail', function (Blueprint $table) {
            $table->integer('id_stock_request_detail')->primary()->autoIncrement();
            $table->integer('id_stock_request');
            $table->integer('id_outlet');
            $table->integer('id_barang');
            $table->integer('harga_beli');
            $table->string('warna', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('qty_po')->default(0);
            $table->integer('qty_open');
            $table->integer('qty_receive')->default(0);
            $table->integer('qty_miss')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_stock_request_detail');
    }
}
