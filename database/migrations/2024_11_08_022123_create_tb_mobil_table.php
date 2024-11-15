<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMobilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mobil', function (Blueprint $table) {
            $table->increments('id_mobil')->primary()->autoIncrement();
            $table->integer('id_pelanggan')->nullable();
            $table->string('nama_mobil')->nullable();
            $table->unsignedBigInteger('merk_mobil_id')->nullable();
            $table->foreign('merk_mobil_id')->references('id')->on('tb_merk_mobil')->onDelete('set null');
            $table->integer('harga_mobil')->nullable();
            $table->string('tahun_mobil', 10)->nullable();
            $table->string('plat_nomor_mobil')->nullable();
            $table->string('nomor_rangka_mobil')->nullable();
            $table->string('nomor_mesin_mobil')->nullable();
            $table->string('kapasitas_mesin_mobil')->nullable();
            $table->string('bahan_bakar_mobil')->nullable();
            $table->string('jenis_transmisi_mobil')->nullable();
            $table->string('km_mobil')->nullable();
            $table->string('bulan_pajak_mobil', 20)->nullable();
            $table->string('tahun_pajak_mobil', 20)->nullable();
            $table->text('pemakaian')->nullable();
            $table->date('terakhir_service_mobil')->nullable();
            $table->date('terakhir_pajak_mobil')->nullable();
            $table->text('keterangan_mobil')->nullable();
            $table->string('lokasi_mobil')->nullable();
            $table->string('kodepos_mobil')->nullable();
            $table->string('lat_mobil')->nullable();
            $table->string('long_mobil')->nullable();
            $table->string('approv_mobil')->default('Draft');
            $table->string('status_mobil')->default('Available');
            $table->dateTime('sold_out_mobil')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->string('delete_mobil', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_mobil');
    }
}
