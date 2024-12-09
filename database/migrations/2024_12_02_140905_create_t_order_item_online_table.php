<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTOrderItemOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_order_item_online', function (Blueprint $table) {
            $table->integer('id_order_item_online')->primary()->autoIncrement();
            $table->unsignedBigInteger('id_order_online');
            $table->integer('id_bengkel');
            $table->unsignedInteger('id_produk')->nullable();
            $table->integer('id_spare_part')->nullable();
            $table->dateTime('tanggal');
            $table->integer('qty');
            $table->integer('harga_beli');
            $table->integer('harga');
            $table->integer('subtotal');
            $table->timestamps();
            // Foreign keys

            $table->foreign('id_order_online')->references('id')->on('t_order_online')->onDelete('cascade');
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('tb_produk')->onDelete('cascade');
            $table->foreign('id_spare_part')->references('id_spare_part')->on('tb_spare_part')->onDelete('cascade');
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_order_item_online');
    }
}
