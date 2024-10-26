<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMJenisBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_jenis_barang', function (Blueprint $table) {
            $table->integer('id_jenis_barang')->primary();
            $table->string('nama_jenis_barang', 50);
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
        Schema::dropIfExists('m_jenis_barang');
    }
}
