<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRawAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_raw_attendance', function (Blueprint $table) {
            $table->bigInteger('id_raw_attendance')->primary();
            $table->integer('id_karyawan');
            $table->string('type', 50)->default('IN');
            $table->string('latitude', 50);
            $table->string('longitude', 50);
            $table->dateTime('dt_absen')->useCurrent();
            $table->string('shift', 50)->nullable();
            $table->string('keterangan', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_raw_attendance');
    }
}
