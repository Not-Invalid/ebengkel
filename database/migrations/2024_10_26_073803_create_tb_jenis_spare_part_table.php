<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbJenisSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_jenis_spare_part', function (Blueprint $table) {
            $table->increments('id_jenis_spare_part');
            $table->string('nama_jenis_spare_part')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->dateTime('updated_date');
            $table->enum('deleted_jenis_spare_part', ['Y', 'N'])->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_jenis_spare_part');
    }
}
