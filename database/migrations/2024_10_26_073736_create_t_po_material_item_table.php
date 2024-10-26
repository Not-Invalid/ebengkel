<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPoMaterialItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_po_material_item', function (Blueprint $table) {
            $table->integer('id_po_material_item')->primary();
            $table->integer('id_outlet');
            $table->integer('id_po_material');
            $table->integer('id_material');
            $table->integer('harga_satuan');
            $table->integer('qty_po')->default(0);
            $table->integer('qty_open');
            $table->integer('qty_receive')->default(0);
            $table->integer('qty_miss')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_po_material_item');
    }
}
