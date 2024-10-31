<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTReturBarangMentahItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_retur_barang_mentah_item', function (Blueprint $table) {
            $table->integer('id_retur_barang_mentah_item')->primary()->autoIncrement();
            $table->integer('id_retur_barang_mentah');
            $table->integer('id_outlet');
            $table->integer('id_barang_mentah');
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
        Schema::dropIfExists('t_retur_barang_mentah_item');
    }
}
