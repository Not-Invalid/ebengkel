<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_pesanan_service', function (Blueprint $table) {
            $table->increments('id_pesanan')->primary();
            $table->integer('id_pelanggan')->nullable();
            $table->integer('id_pegawai')->nullable(true);
            $table->integer('id_bengkel');
            $table->string('telp_pelanggan')->nullable();
            $table->string('nama_pemesan');
            $table->date('tgl_pesanan');
            $table->string('nama_services');
            $table->integer('jumlah_services_online')->nullable();
            $table->integer('jumlah_services_offline')->nullable();
            $table->string('status');
            $table->string('jenis');
            $table->integer('total_pesanan')->nullable();
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('tb_pelanggan')->onDelete('cascade');
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('tb_pegawai')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tb_pesanan_service');
    }
};
