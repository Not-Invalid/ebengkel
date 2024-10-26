<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMOutletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_outlet', function (Blueprint $table) {
            $table->integer('id_outlet')->primary();
            $table->integer('id_bengkel');
            $table->string('nama_outlet', 100);
            $table->string('alamat', 500);
            $table->string('no_telp', 50);
            $table->string('is_active', 1)->default('N');
            $table->string('is_trial', 1)->nullable();
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
        Schema::dropIfExists('m_outlet');
    }
}
