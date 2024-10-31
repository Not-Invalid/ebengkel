<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPoItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_po_item', function (Blueprint $table) {
            $table->integer('id_po_item')->primary()->autoIncrement();
            $table->integer('id_outlet');
            $table->integer('id_po');
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
        Schema::dropIfExists('t_po_item');
    }
}
