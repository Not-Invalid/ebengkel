<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPengembalianItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pengembalian_item', function (Blueprint $table) {
            $table->integer('id_pengembalian_item')->primary();
            $table->integer('id_pengembalian');
            $table->integer('id_outlet');
            $table->integer('id_order');
            $table->integer('id_barang');
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_pengembalian_item');
    }
}
