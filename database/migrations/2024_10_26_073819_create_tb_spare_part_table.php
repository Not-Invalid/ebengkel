<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_spare_part', function (Blueprint $table) {
            $table->integer('id_spare_part')->primary()->autoIncrement();
            $table->integer('id_bengkel')->nullable();
            $table->integer('id_jenis_spare_part')->nullable();
            $table->unsignedBigInteger('id_kategori_spare_part')->nullable(); // Make it nullable
            $table->string('kualitas_spare_part')->nullable();
            $table->string('merk_spare_part')->nullable();
            $table->string('nama_spare_part')->nullable();
            $table->integer('harga_spare_part')->nullable();
            $table->text('keterangan_spare_part')->nullable();
            $table->integer('stok_spare_part')->nullable();
            $table->dateTime('create_spare_part')->nullable();
            $table->string('delete_spare_part', 1)->default('N');
            $table->foreign('id_kategori_spare_part')->references('id_kategori_spare_part')->on('tb_kategori_spare_part')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_spare_part');
    }
}
