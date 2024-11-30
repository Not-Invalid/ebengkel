<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pengeluaran', function (Blueprint $table) {
            $table->integer('id_pengeluaran')->primary()->autoIncrement();
            $table->integer('id_jenis_pengeluaran');
            $table->integer('id_bengkel');
            $table->string('keterangan', 1000);
            $table->date('tanggal');
            $table->integer('nominal');
            $table->string('input_by', 1000);
            $table->dateTime('input_date')->useCurrent();
            $table->string('is_delete', 1)->default('N');

            $table->foreign('id_jenis_pengeluaran')->references('id_jenis_pengeluaran')->on('m_jenis_pengeluaran')->onDelete('cascade');
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_pengeluaran');
    }
}
