<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMTargetBulananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_target_bulanan', function (Blueprint $table) {
            $table->integer('id_target_bulanan')->primary();
            $table->integer('id_outlet');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('target');
            $table->string('keterangan', 500);
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
        Schema::dropIfExists('m_target_bulanan');
    }
}
