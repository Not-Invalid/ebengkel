<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFotoMobilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_foto_mobil', function (Blueprint $table) {
            $table->increments('id_foto_mobil')->autoIncrement();
            $table->integer('id_mobil');
            $table->integer('id_pelanggan');
            $table->text('file_foto_mobil_1');
            $table->text('file_foto_mobil_2')->nullable();
            $table->text('file_foto_mobil_3')->nullable();
            $table->text('file_foto_mobil_4')->nullable();
            $table->text('file_foto_mobil_5')->nullable();
            $table->dateTime('create_file_foto_mobil');
            $table->string('delete_file_foto_mobil', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_foto_mobil');
    }
}
