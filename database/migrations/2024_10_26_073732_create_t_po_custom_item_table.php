<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPoCustomItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_po_custom_item', function (Blueprint $table) {
            $table->integer('id_po_custom_detail')->primary()->autoIncrement();
            $table->integer('id_po_custom');
            $table->integer('id_outlet');
            $table->integer('id_category');
            $table->string('nama_barang', 500);
            $table->string('lengan', 50)->default('PENDEK');
            $table->string('size', 50);
            $table->string('warna', 100);
            $table->string('keterangan', 500);
            $table->string('attachment', 500);
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('subtotal');
            $table->string('status', 50)->default('NEW');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_po_custom_item');
    }
}
