<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTCancelTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_cancel_transaksi', function (Blueprint $table) {
            $table->integer('id_cancel_transaksi')->primary()->autoIncrement();
            $table->integer('id_order')->nullable();
            $table->integer('total_qty')->nullable();
            $table->integer('total_harga')->nullable();
            $table->string('input_by', 100)->nullable();
            $table->string('input_date', 100)->nullable();
            $table->string('is_delete', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_cancel_transaksi');
    }
}
