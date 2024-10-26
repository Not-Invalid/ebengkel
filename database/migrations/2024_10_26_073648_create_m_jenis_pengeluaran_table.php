<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMJenisPengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_jenis_pengeluaran', function (Blueprint $table) {
            $table->integer('id_jenis_pengeluaran')->primary();
            $table->string('nama_jenis_pengeluaran', 100);
            $table->string('keterangan', 1000);
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
        Schema::dropIfExists('m_jenis_pengeluaran');
    }
}
