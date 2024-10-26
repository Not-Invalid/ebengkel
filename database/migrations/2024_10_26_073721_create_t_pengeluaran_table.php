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
            $table->integer('id_pengeluaran')->primary();
            $table->integer('id_jenis_pengeluaran');
            $table->integer('id_outlet');
            $table->string('keterangan', 1000);
            $table->date('tanggal');
            $table->integer('nominal');
            $table->string('input_by', 1000);
            $table->dateTime('input_date')->useCurrent();
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
        Schema::dropIfExists('t_pengeluaran');
    }
}
