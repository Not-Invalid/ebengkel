<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbReviewBengkelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ulasan', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->integer('id_pelanggan');
            $table->integer('id_bengkel');
            $table->integer('rating')->comment('Rating 1-5');
            $table->text('komentar')->nullable();
            $table->timestamps();

            // Relasi dengan tb_pelanggan dan tb_bengkel
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('tb_pelanggan')->onDelete('cascade');
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_ulasan');
    }
}
