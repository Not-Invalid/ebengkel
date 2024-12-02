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
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('tb_pelanggan')->onDelete('cascade');
            $table->integer('id_bengkel');
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');
            $table->string('telp_pelanggan')->nullable();
            $table->string('nama_pemesan');
            $table->date('tgl_pesanan');
            $table->string('nama_service');
            $table->string('status');
            $table->integer('total_pesanan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tb_pesanan_service');
    }
};
