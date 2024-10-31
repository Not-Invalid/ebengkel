<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_karyawan', function (Blueprint $table) {
            $table->integer('id_karyawan')->primary()->autoIncrement();
            $table->integer('id_pengguna')->nullable();
            $table->integer('id_outlet')->default(1);
            $table->string('username', 30)->nullable();
            $table->string('password')->nullable();
            $table->string('alias')->nullable();
            $table->string('level', 15)->nullable();
            $table->string('nama_lengkap', 50)->nullable();
            $table->string('jenis_kelamin', 15)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('status_kawin', 15)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('nomor_ktp', 30)->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('alamat')->nullable();
            $table->string('status', 15)->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->enum('is_delete', ['N', 'Y'])->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_karyawan');
    }
}
