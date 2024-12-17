<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kota', function (Blueprint $table) {
            $table->integer('city_id')->primary();
            $table->integer('province_id')->nullable();
            $table->string('city_name', 255)->nullable();
            $table->char('postal_code', 5)->nullable();

            $table->foreign('province_id')->references('province_id')->on('m_provinsi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_kota');
    }
}
