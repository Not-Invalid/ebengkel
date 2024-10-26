<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_customer', function (Blueprint $table) {
            $table->integer('id_customer')->primary();
            $table->integer('id_outlet');
            $table->string('nama', 50);
            $table->string('no_telp', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('alamat', 500)->nullable();
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
        Schema::dropIfExists('m_customer');
    }
}
