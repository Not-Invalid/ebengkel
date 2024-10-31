<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTStockOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_stock_opname', function (Blueprint $table) {
            $table->integer('id_stock_opname')->primary()->autoIncrement();
            $table->integer('id_outlet');
            $table->date('tanggal');
            $table->integer('qty_before');
            $table->integer('qty_after');
            $table->integer('qty_miss');
            $table->string('keterangan', 1000);
            $table->string('input_by', 100);
            $table->dateTime('input_date')->useCurrent();
            $table->string('is_lock', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_stock_opname');
    }
}
