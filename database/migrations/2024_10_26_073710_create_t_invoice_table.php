<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_invoice', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->integer('id_pelanggan');
            $table->string('id_order');
            $table->string('status_invoice', 50)->default('PENDING');
            $table->date('jatuh_tempo');
            $table->dateTime('tanggal_invoice');
            $table->dateTime('tanggal_bayar')->nullable();
            $table->string('nama_rekening', 100)->nullable();
            $table->string('no_rekening', 50)->nullable();
            $table->string('note', 500)->nullable();
            $table->string('jenis_pembayaran')->nullable();
            $table->string('tanggal_transfer', 10)->nullable();
            $table->string('nominal_transfer', 20)->nullable();
            $table->string('bukti_bayar', 250)->nullable();
            $table->enum('is_delete', ['Y', 'N'])->default('N');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_invoice');
    }
}
