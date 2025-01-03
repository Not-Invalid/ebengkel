<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPoMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_po_material', function (Blueprint $table) {
            $table->integer('id_po_material')->primary()->autoIncrement();
            $table->integer('id_outlet');
            $table->string('kode_po_material', 50);
            $table->date('tanggal');
            $table->string('supplier', 100);
            $table->string('keterangan', 1000);
            $table->string('is_lock', 1)->default('N');
            $table->string('is_receive', 1)->default('N');
            $table->string('receive_status', 50)->default('PENDING');
            $table->string('input_by', 50);
            $table->dateTime('input_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_po_material');
    }
}
