<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFotoSparepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_foto_spare_part', function (Blueprint $table) {
            $table->increments('id_foto_spare_part')->autoIncrement();
            $table->integer('id_spare_part')->nullable(true); // Nullable for the sake of optional relationships
            $table->text('file_foto_spare_part_1');
            $table->text('file_foto_spare_part_2')->nullable();
            $table->text('file_foto_spare_part_3')->nullable();
            $table->text('file_foto_spare_part_4')->nullable();
            $table->text('file_foto_spare_part_5')->nullable();
            $table->dateTime('create_file_foto_spare_part');
            $table->string('delete_file_foto_spare_part', 1)->default('N');
            $table->timestamps();
            // Foreign key untuk hubungan dengan tabel tb_produk
            $table->foreign('id_spare_part')->references('id_spare_part')->on('tb_spare_part')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_foto_spare_part');
    }
}
