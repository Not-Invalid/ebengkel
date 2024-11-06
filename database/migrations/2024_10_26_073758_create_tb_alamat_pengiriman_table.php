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
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kecamatan')->nullable();
            $table->timestamps();
            $table->string('delete_alamat_pengiriman', 1)->default('N');
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
