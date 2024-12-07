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
            $table->id();
            $table->string('order_id', 20)->unique();
            $table->integer('id_bengkel')->nullable();
            $table->integer('id_pelanggan')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->decimal('total_harga', 10, 0)->nullable();
            $table->string('status_order', 50)->default('TEMP');
            $table->string('jenis_pengiriman', 50)->nullable();
            $table->string('kurir', 50)->nullable();
            $table->string('biaya_pengiriman', 50)->nullable();
            $table->string('grand_total', 50)->nullable();
            $table->string('atas_nama', 50)->nullable();
            $table->string('alamat_pengiriman', 1000)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kode_pos', 50)->nullable();
            $table->string('no_telp', 50)->nullable();
            $table->string('status_pengiriman', 50)->nullable();
            $table->string('no_resi', 50)->nullable();
            $table->dateTime('tanggal_kirim')->nullable();
            $table->dateTime('tanggal_diterima')->nullable();
            $table->string('is_delete', 1)->default('N');
            $table->timestamps();

            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('tb_pelanggan')->onDelete('cascade');
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
