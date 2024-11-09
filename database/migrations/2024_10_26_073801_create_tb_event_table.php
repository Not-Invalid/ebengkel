<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_event', function (Blueprint $table) {
            $table->integer('id_event')->primary()->autoIncrement();
            $table->string('nama_event')->nullable();
            $table->date('event_start_date')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('alamat_event')->nullable();
            $table->text('image_cover')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('tipe_harga')->nullable();
            $table->integer('harga')->default(0);
            $table->timestamps();
            $table->string('delete_event', 1)->default('N');
            $table->date('event_end_date')->nullable();
            $table->json('agenda_acara')->nullable();
            $table->json('bintang_tamu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_event');
    }
}
