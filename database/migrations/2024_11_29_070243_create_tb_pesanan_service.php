<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_pesanan_service', function (Blueprint $table) {
            // ID Pesanan sebagai Primary Key
            $table->increments('id_pesanan')->primary();

            // Foreign key to tb_pelanggan (signed integer)
            $table->integer('id_pelanggan');  // Don't use unsigned here
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('tb_pelanggan')->onDelete('cascade');

            // Foreign key to tb_bengkel
            $table->integer('id_bengkel'); // This can remain unsigned as per the table definition
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');

            // Nama Pemesan
            $table->string('nama_pemesan');

            // Tanggal Pesanan
            $table->date('tgl_pesanan');

            // Nama Service yang dipesan
            $table->string('nama_service');

            // Status Pesanan
            $table->string('status');

            // Kolom Timestamps: created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('tb_pesanan_service');
    }
};
