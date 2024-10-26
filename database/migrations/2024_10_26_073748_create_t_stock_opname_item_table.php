<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTStockOpnameItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_stock_opname_item', function (Blueprint $table) {
            $table->integer('id_stock_opname_item')->primary();
            $table->integer('id_stock_opname');
            $table->integer('id_outlet');
            $table->integer('id_barang');
            $table->string('warna', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('qty_before');
            $table->integer('qty_after');
            $table->integer('qty_miss');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_stock_opname_item');
    }
}
