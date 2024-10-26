<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTStockMovementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_stock_movement', function (Blueprint $table) {
            $table->integer('id_stock_movement')->primary();
            $table->string('kode_stock_movement', 50);
            $table->integer('id_outlet');
            $table->integer('id_outlet_tujuan');
            $table->integer('total_qty');
            $table->string('keterangan', 500)->nullable();
            $table->string('kode_harga', 10);
            $table->string('is_lock', 1)->default('N');
            $table->string('status', 50)->default('DIKIRIM');
            $table->string('receive_by', 50)->nullable();
            $table->dateTime('receive_date')->nullable();
            $table->string('input_by', 50);
            $table->dateTime('input_date')->useCurrent();
            $table->string('update_by', 50)->nullable();
            $table->dateTime('update_date')->nullable();
            $table->string('delete_by', 50)->nullable();
            $table->dateTime('delete_date')->nullable();
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
        Schema::dropIfExists('t_stock_movement');
    }
}
