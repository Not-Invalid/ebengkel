<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPenjualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_penjual', function (Blueprint $table) {
            $table->integer('id_penjual')->primary()->autoIncrement();
            $table->string('nama_penjual')->nullable();
            $table->string('jenkel_penjual')->nullable();
            $table->date('tgl_lahir_penjual')->nullable();
            $table->text('alamat_penjual')->nullable();
            $table->string('telp_penjual')->nullable();
            $table->string('email_penjual')->nullable();
            $table->text('foto_penjual')->nullable();
            $table->string('password_penjual')->nullable();
            $table->string('status_penjual')->nullable();
            $table->dateTime('bergabung_penjual')->nullable();
            $table->string('delete_penjual', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_penjual');
    }
}
