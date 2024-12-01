<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbManagementStockOpnameTable extends Migration
{
    public function up()
    {
        Schema::create('tb_management_stock_opname', function (Blueprint $table) {
            $table->id('id_opname');
            $table->integer('id_bengkel');
            $table->integer('id_pegawai')->nullable(true);
            $table->unsignedInteger('id_produk')->nullable(true); // Nullable for the sake of optional relationships
            $table->integer('id_spare_part')->nullable(true); // Nullable for the sake of optional relationships
            $table->enum('type', ['product', 'spare_part']);
            $table->integer('actual_quantity');
            $table->string('description')->nullable();
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('tb_produk')->onDelete('cascade');
            $table->foreign('id_spare_part')->references('id_spare_part')->on('tb_spare_part')->onDelete('cascade');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('tb_pegawai')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_management_stock_opname');
    }
}
