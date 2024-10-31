<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBarangMentahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_barang_mentah', function (Blueprint $table) {
            $table->integer('id_barang_mentah')->primary()->autoIncrement();
            $table->string('nama_barang', 100);
            $table->string('keterangan', 500);
            $table->string('satuan', 50);
            $table->integer('harga_satuan');
            $table->decimal('last_stock', 10, 2)->default(0.00);
            $table->string('input_by', 50);
            $table->dateTime('input_date')->useCurrent();
            $table->string('is_delete', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_barang_mentah');
    }
}
