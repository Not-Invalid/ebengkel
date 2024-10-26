<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pengembalian', function (Blueprint $table) {
            $table->integer('id_pengembalian')->primary();
            $table->integer('id_outlet');
            $table->integer('id_order');
            $table->string('keterangan', 500);
            $table->date('tanggal');
            $table->string('is_lock', 1)->default('N');
            $table->string('input_by', 50);
            $table->dateTime('input_date');
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
        Schema::dropIfExists('t_pengembalian');
    }
}
