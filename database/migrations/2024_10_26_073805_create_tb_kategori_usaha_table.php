<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKategoriUsahaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kategori_usaha', function (Blueprint $table) {
            $table->integer('id_kategori_usaha')->primary()->autoIncrement();
            $table->string('nama_kategori_usaha')->nullable();
            $table->text('foto_kategori_usaha')->nullable();
            $table->string('delete_kategori_usaha', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_kategori_usaha');
    }
}
