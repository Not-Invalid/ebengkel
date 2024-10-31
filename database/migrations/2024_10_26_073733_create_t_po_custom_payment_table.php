<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPoCustomPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_po_custom_payment', function (Blueprint $table) {
            $table->integer('id_po_custom_payment')->primary()->autoIncrement();
            $table->integer('id_outlet');
            $table->integer('id_po_custom');
            $table->date('tanggal_bayar');
            $table->integer('total_harga');
            $table->integer('total_bayar');
            $table->integer('kembali');
            $table->string('jenis_pembayaran', 50);
            $table->integer('no_kartu');
            $table->integer('sisa_tagihan');
            $table->string('keterangan', 200)->nullable();
            $table->string('input_by', 50);
            $table->dateTime('input_date')->useCurrent();
            $table->string('delete_by', 50)->nullable();
            $table->dateTime('delete_date')->nullable();
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
        Schema::dropIfExists('t_po_custom_payment');
    }
}
