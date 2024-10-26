<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPengeluaranBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pengeluaran_barang', function (Blueprint $table) {
            $table->integer('id_pengeluaran_barang')->primary();
            $table->integer('id_outlet');
            $table->date('tanggal');
            $table->string('tujuan', 100);
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
        Schema::dropIfExists('t_pengeluaran_barang');
    }
}
