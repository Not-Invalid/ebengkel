<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbLogPelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_log_pelanggan', function (Blueprint $table) {
            $table->integer('id_log_pelanggan')->primary()->autoIncrement();
            $table->integer('id_pelanggan')->nullable();
            $table->dateTime('tgl_log_pelanggan')->nullable();
            $table->string('delete_log_pelanggan', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_log_pelanggan');
    }
}
