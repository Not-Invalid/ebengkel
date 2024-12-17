<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_kecamatan', function (Blueprint $table) {
            $table->integer('subdistrict_id')->primary();
            $table->integer('city_id')->nullable();
            $table->string('subdistrict_name', 255)->nullable();

            $table->foreign('city_id')->references('city_id')->on('m_kota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kecamatan');
    }
};
