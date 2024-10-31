<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBarangMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_barang_masuk', function (Blueprint $table) {
            $table->integer('id_barang_masuk')->primary()->autoIncrement();
            $table->integer('id_outlet');
            $table->string('jenis_barang', 50);
            $table->date('tanggal');
            $table->string('keterangan', 100);
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
        Schema::dropIfExists('t_barang_masuk');
    }
}
