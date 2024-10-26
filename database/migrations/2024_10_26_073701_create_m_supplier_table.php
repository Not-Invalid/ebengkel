<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_supplier', function (Blueprint $table) {
            $table->integer('id_supplier')->primary();
            $table->integer('id_outlet');
            $table->string('nama_supplier', 100);
            $table->string('alamat', 500);
            $table->string('no_telp', 50);
            $table->string('is_active', 1)->default('N');
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
        Schema::dropIfExists('m_supplier');
    }
}
