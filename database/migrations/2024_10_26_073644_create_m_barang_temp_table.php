<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBarangTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_barang_temp', function (Blueprint $table) {
            $table->integer('id_barang_temp')->primary();
            $table->string('barcode', 50);
            $table->string('nama_barang', 50);
            $table->string('warna', 50);
            $table->string('size', 50);
            $table->integer('id_merk');
            $table->string('merk', 50);
            $table->integer('id_jenis_barang');
            $table->string('jenis_barang', 50);
            $table->integer('id_category');
            $table->string('category', 50);
            $table->integer('id_bahan');
            $table->string('bahan', 50);
            $table->string('gender', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_barang_temp');
    }
}
