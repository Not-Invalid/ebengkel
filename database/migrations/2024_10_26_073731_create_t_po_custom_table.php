<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPoCustomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_po_custom', function (Blueprint $table) {
            $table->integer('id_po_custom')->primary();
            $table->integer('id_outlet');
            $table->integer('id_wo')->nullable();
            $table->string('kode_po_custom', 50);
            $table->date('tanggal');
            $table->integer('id_customer');
            $table->string('nama_team', 200);
            $table->integer('total_qty');
            $table->integer('total_harga');
            $table->integer('sisa_tagihan');
            $table->date('deadline')->nullable();
            $table->string('keterangan', 500);
            $table->string('bahan', 100);
            $table->string('kantong', 100);
            $table->dateTime('tanggal_wo')->nullable();
            $table->dateTime('tanggal_finish_wo')->nullable();
            $table->dateTime('tanggal_ambil')->nullable();
            $table->string('ambil_oleh', 50)->nullable();
            $table->string('status_po', 50)->default('NEW');
            $table->string('status_pembayaran', 50)->default('BELUM LUNAS');
            $table->string('input_by', 50);
            $table->dateTime('input_date')->useCurrent();
            $table->string('update_by', 50)->nullable();
            $table->dateTime('update_date')->nullable();
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
        Schema::dropIfExists('t_po_custom');
    }
}
