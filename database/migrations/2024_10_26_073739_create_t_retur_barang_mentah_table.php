<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTReturBarangMentahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_retur_barang_mentah', function (Blueprint $table) {
            $table->integer('id_retur_barang_mentah')->primary();
            $table->integer('id_outlet');
            $table->integer('id_po_barang_mentah');
            $table->date('tanggal');
            $table->string('keterangan', 1000);
            $table->string('is_lock', 1)->default('N');
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
        Schema::dropIfExists('t_retur_barang_mentah');
    }
}
