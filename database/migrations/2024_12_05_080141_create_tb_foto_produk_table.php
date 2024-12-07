<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFotoProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_foto_produk', function (Blueprint $table) {
            $table->increments('id_foto_produk')->autoIncrement();
            $table->unsignedInteger('id_produk')->nullable(true); // Nullable for the sake of optional relationships
            $table->text('file_foto_produk_1');
            $table->text('file_foto_produk_2')->nullable();
            $table->text('file_foto_produk_3')->nullable();
            $table->text('file_foto_produk_4')->nullable();
            $table->text('file_foto_produk_5')->nullable();
            $table->dateTime('create_file_foto_produk');
            $table->string('delete_file_foto_produk', 1)->default('N');
            $table->timestamps();
            // Foreign key untuk hubungan dengan tabel tb_produk
            $table->foreign('id_produk')->references('id_produk')->on('tb_produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_foto_produk');
    }
}
