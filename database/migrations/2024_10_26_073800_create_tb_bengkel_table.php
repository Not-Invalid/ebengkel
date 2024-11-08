<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbBengkelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bengkel', function (Blueprint $table) {
            $table->integer('id_bengkel')->primary()->autoIncrement();
            $table->integer('id_pelanggan')->nullable();
            $table->string('nama_bengkel')->nullable();
            $table->string('tagline_bengkel')->nullable();
            $table->text('foto_bengkel')->nullable();
            $table->text('foto_cover_bengkel')->nullable();
            $table->text('alamat_bengkel')->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('tiktok')->nullable();
            $table->string('instagram')->nullable();
            $table->string('open_day')->nullable();    
            $table->string('close_day')->nullable();   
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->json('service_available')->nullable();
            $table->json('payment')->nullable();
            $table->string('kodepos_bengkel')->nullable();
            $table->string('gmaps')->nullable();
            $table->string('lokasi_bengkel')->nullable();
            $table->string('lat_bengkel')->nullable();
            $table->string('long_bengkel')->nullable();
            $table->string('status_bengkel')->nullable();
            $table->dateTime('create_bengkel')->nullable();
            $table->string('delete_bengkel', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down($table)
    {
        Schema::dropIfExists('tb_bengkel');
    }
}
