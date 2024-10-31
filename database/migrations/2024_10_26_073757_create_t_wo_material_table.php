<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTWoMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_wo_material', function (Blueprint $table) {
            $table->integer('id_wo_material')->primary()->autoIncrement();
            $table->integer('id_wo')->nullable();
            $table->integer('id_material');
            $table->integer('id_proses');
            $table->string('keterangan', 500)->nullable();
            $table->decimal('qty', 10, 2);
            $table->integer('harga_satuan');
            $table->decimal('subtotal', 10, 2);
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
        Schema::dropIfExists('t_wo_material');
    }
}
