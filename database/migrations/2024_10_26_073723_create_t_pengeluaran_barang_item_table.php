<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPengeluaranBarangItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pengeluaran_barang_item', function (Blueprint $table) {
            $table->integer('id_pengeluaran_barang_item')->primary()->autoIncrement();
            $table->integer('id_pengeluaran_barang');
            $table->integer('id_outlet');
            $table->integer('id_barang');
            $table->string('warna', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_pengeluaran_barang_item');
    }
}
