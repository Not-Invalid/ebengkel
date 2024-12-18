<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_order', function (Blueprint $table) {
            $table->integer('id_order')->primary()->autoIncrement();
            $table->string('kode_order', 20)->unique();
            $table->string('nama_customer', 255)->nullable();
            $table->integer('id_bengkel')->nullable();
            $table->integer('id_voucher')->nullable();
            $table->dateTime('tanggal')->useCurrent();
            $table->string('tipe', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('jenis_pembayaran', 50)->nullable();
            $table->string('no_kartu', 50)->nullable();
            $table->integer('harga')->default(0);
            $table->integer('diskon')->default(0);
            $table->integer('ppn')->nullable();
            $table->integer('total_harga')->nullable();
            $table->integer('total_qty')->nullable();
            $table->integer('nominal_bayar')->nullable();
            $table->integer('kembali')->nullable();
            $table->string('input_by', 50);
            $table->string('shift', 50)->nullable();
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
        Schema::table('t_order', function (Blueprint $table) {
            $table->dropColumn('id_bengkel');
        });
    }
}
