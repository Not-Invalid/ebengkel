<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTStockMovementItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_stock_movement_item', function (Blueprint $table) {
            $table->integer('id_stock_movement_detail')->primary();
            $table->integer('id_stock_movement');
            $table->integer('id_barang');
            $table->integer('qty');
            $table->integer('qty_receive')->nullable();
            $table->string('valuasi', 20);
            $table->integer('harga');
            $table->integer('subtotal');
            $table->string('keterangan', 500)->nullable();
            $table->string('keterangan_receive', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_stock_movement_item');
    }
}
