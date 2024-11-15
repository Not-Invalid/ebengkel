<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPenerimaanMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_penerimaan_material', function (Blueprint $table) {
            $table->integer('id_penerimaan_material')->primary()->autoIncrement();
            $table->integer('id_outlet');
            $table->integer('id_po_material')->nullable();
            $table->date('tanggal');
            $table->string('keterangan', 1000);
            $table->string('is_lock', 1)->default('N');
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
        Schema::dropIfExists('t_penerimaan_material');
    }
}
