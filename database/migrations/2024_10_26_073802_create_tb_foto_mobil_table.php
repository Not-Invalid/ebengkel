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
            $table->string('id_mobil', 20);
            $table->string('id_pelanggan', 20);
            $table->text('file_foto_mobil');
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
