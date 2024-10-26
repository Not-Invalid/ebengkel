<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_barang', function (Blueprint $table) {
            $table->integer('id_barang')->primary();
            $table->string('id_outlet', 50)->default('1');
            $table->string('barcode', 50)->nullable();
            $table->string('barcode_asli', 50)->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('foreign_name')->nullable();
            $table->string('specification')->nullable();
            $table->integer('id_category')->default(1);
            $table->integer('id_jenis_barang')->default(1);
            $table->integer('id_merk')->default(1);
            $table->integer('id_bahan')->default(1);
            $table->integer('id_kualitas_produk');
            $table->string('produsen', 300)->nullable();
            $table->date('expired_date')->nullable();
            $table->integer('minimum_stock')->nullable();
            $table->integer('minimum_expired')->nullable();
            $table->integer('harga_et')->nullable();
            $table->integer('harga_jual2')->nullable();
            $table->integer('harga_jual3')->nullable();
            $table->integer('harga_jual4')->nullable();
            $table->integer('harga_jual5')->nullable();
            $table->string('gender', 50)->default('MEN');
            $table->string('satuan', 50)->default('PCS');
            $table->string('warna', 59)->default('-');
            $table->string('lokasi', 50)->default('-');
            $table->string('lengan', 50)->default('-');
            $table->string('gambar', 100)->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('harga_beli')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->integer('last_stock')->default(0);
            $table->enum('is_delete', ['N', 'Y'])->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_barang');
    }
}
