<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_stock', function (Blueprint $table) {
            $table->integer('id_stock')->primary()->autoIncrement();
            $table->integer('id_outlet');
            $table->integer('id_barang');
            $table->integer('stock_akhir');
            $table->date('expired_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_stock');
    }
}
