<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_order_item', function (Blueprint $table) {
            $table->integer('id_order_item')->primary()->autoIncrement();
            $table->integer('id_order');
            $table->integer('id_bengkel');
            $table->unsignedInteger('id_produk')->nullable();
            $table->integer('id_spare_part')->nullable();
            $table->dateTime('tanggal')->useCurrent();
            $table->string('warna', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('qty');
            $table->integer('harga');
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
        Schema::dropIfExists('t_order_item');
    }
}
