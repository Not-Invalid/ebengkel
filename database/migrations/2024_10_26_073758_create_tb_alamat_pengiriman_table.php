<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAlamatPengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_alamat_pengiriman', function (Blueprint $table) {
            $table->integer('id_alamat_pengiriman')->primary()->autoIncrement();
            $table->integer('id_pelanggan')->nullable();
            $table->text('nama_penerima')->nullable();
            $table->string('telp_penerima')->nullable();
            $table->text('lokasi_alamat_pengiriman')->nullable();
            $table->string('kodepos_alamat_pengiriman')->nullable();
            $table->string('lat_alamat_pengiriman')->nullable();
            $table->string('long_alamat_pengiriman')->nullable();
            $table->string('status_alamat_pengiriman')->nullable();
            $table->integer('provinsi_id')->nullable();
            $table->integer('kota_id')->nullable();
            $table->integer('kecamatan_id')->nullable();
            $table->timestamps();
            $table->string('delete_alamat_pengiriman', 1)->default('N');

            $table->foreign('provinsi_id')->references('province_id')->on('m_provinsi')->onDelete('cascade');
            $table->foreign('kota_id')->references('city_id')->on('m_kota')->onDelete('cascade');
            $table->foreign('kecamatan_id')->references('subdistrict_id')->on('m_kecamatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_alamat_pengiriman');
    }
}
