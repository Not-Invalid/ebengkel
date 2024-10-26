<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbBarangServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_barang_services', function (Blueprint $table) {
            $table->integer('id_barang_services')->primary();
            $table->integer('id_services')->nullable();
            $table->integer('id_spare_part')->nullable();
            $table->string('delete_barang_services', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_barang_services');
    }
}
