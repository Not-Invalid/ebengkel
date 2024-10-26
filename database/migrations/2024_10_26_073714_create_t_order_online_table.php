<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTOrderOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_order_online', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('id_outlet')->nullable();
            $table->integer('id_customer')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->integer('total_qty')->default(0);
            $table->decimal('total_harga', 10, 0)->nullable();
            $table->string('status_pengiriman', 50)->nullable();
            $table->string('kurir', 50)->nullable();
            $table->string('biaya_pengiriman', 50)->nullable();
            $table->string('grand_total', 50)->nullable();
            $table->string('atas_nama', 50)->nullable();
            $table->string('alamat_pengiriman', 1000)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('desa', 100)->nullable();
            $table->string('kode_pos', 50)->nullable();
            $table->string('no_telp', 50)->nullable();
            $table->string('jenis_pengiriman', 50)->nullable();
            $table->string('no_resi', 50)->nullable();
            $table->dateTime('tanggal_kirim')->nullable();
            $table->dateTime('tanggal_diterima')->nullable();
            $table->string('status_order', 50)->default('TEMP');
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
        Schema::dropIfExists('t_order_online');
    }
}
