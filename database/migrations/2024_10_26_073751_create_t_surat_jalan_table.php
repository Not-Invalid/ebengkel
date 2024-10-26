<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTSuratJalanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_surat_jalan', function (Blueprint $table) {
            $table->integer('id_surat_jalan')->primary();
            $table->integer('id_po_custom');
            $table->string('no_surat_jalan', 50);
            $table->date('tanggal');
            $table->string('notes', 5000)->nullable();
            $table->integer('total_qty');
            $table->integer('id_outlet');
            $table->string('diterima_oleh', 50)->nullable();
            $table->dateTime('tgl_diterima')->nullable();
            $table->string('status_pengiriman', 50)->default('PENDING');
            $table->string('input_by', 50);
            $table->dateTime('input_date');
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
        Schema::dropIfExists('t_surat_jalan');
    }
}
