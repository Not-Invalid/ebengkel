<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_services', function (Blueprint $table) {
            $table->integer('id_services')->primary()->autoIncrement();
            $table->integer('id_bengkel')->nullable();
            $table->string('nama_services')->nullable();
            $table->integer('harga_services')->nullable();
            $table->text('keterangan_services')->nullable();
            $table->text('foto_services')->nullable();
            $table->integer('jumlah_services_online')->nullable();
            $table->integer('jumlah_services_offline')->nullable();
            $table->dateTime('create_services')->nullable();
            $table->string('delete_services', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_services');
    }
}
