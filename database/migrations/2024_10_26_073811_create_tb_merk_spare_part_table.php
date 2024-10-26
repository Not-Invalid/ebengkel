<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMerkSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_merk_spare_part', function (Blueprint $table) {
            $table->increments('id_merk_spare_part');
            $table->string('nama_merk_spare_part')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->enum('deleted_merk_spare_part', ['Y', 'N'])->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_merk_spare_part');
    }
}
