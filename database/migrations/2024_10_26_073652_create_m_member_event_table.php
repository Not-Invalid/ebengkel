<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMMemberEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_member_event', function (Blueprint $table) {
            $table->integer('id_member')->primary()->autoIncrement();
            $table->string('nama');
            $table->integer('id_event');
            $table->string('nohp', 15);
            $table->string('email');
            $table->string('jenis_mobil', 50);
            $table->string('type_mobil', 50);
            $table->string('tahun_mobil', 5);
            $table->string('foto_mobil');
            $table->timestamps();
            $table->string('delete_member', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_member_event');
    }
}
