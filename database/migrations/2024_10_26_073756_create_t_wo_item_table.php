<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTWoItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_wo_item', function (Blueprint $table) {
            $table->integer('id_wo_item')->primary()->autoIncrement();
            $table->integer('id_wo')->nullable();
            $table->integer('id_barang')->nullable();
            $table->string('nama_barang', 100);
            $table->string('keterangan', 500);
            $table->string('lengan', 50)->nullable();
            $table->integer('id_category');
            $table->integer('id_bahan');
            $table->string('nama_category', 50)->nullable();
            $table->string('warna', 50);
            $table->string('size', 50);
            $table->string('satuan', 50)->nullable();
            $table->integer('harga_satuan');
            $table->integer('harga_modal')->nullable();
            $table->integer('qty');
            $table->integer('subtotal');
            $table->string('attachment', 1000);
            $table->string('status', 50)->default('PENDING');
            $table->dateTime('process_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->string('input_by', 50);
            $table->dateTime('input_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_wo_item');
    }
}
