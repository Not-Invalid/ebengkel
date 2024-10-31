<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_level', function (Blueprint $table) {
            $table->integer('id_level')->primary()->autoIncrement();
            $table->integer('id_pelanggan')->nullable();
            $table->string('nama_level')->nullable();
            $table->string('delete_level', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_level');
    }
}
