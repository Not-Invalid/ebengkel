<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTWoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_wo', function (Blueprint $table) {
            $table->integer('id_wo')->primary();
            $table->integer('id_po_custom');
            $table->integer('id_stock_request')->nullable();
            $table->integer('id_outlet');
            $table->integer('id_customer')->nullable();
            $table->date('tanggal_wo');
            $table->string('status_wo', 50)->default('NEW');
            $table->integer('total_qty');
            $table->integer('total_harga');
            $table->integer('est_manhour')->default(1);
            $table->integer('actual_manhour')->default(1);
            $table->string('keterangan', 1000)->nullable();
            $table->dateTime('tanggal_mulai')->useCurrent();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->date('deadline')->nullable();
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
        Schema::dropIfExists('t_wo');
    }
}
