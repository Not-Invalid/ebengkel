<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pelanggan', function (Blueprint $table) {
            $table->integer('id_pelanggan')->autoIncrement()->primary();
            $table->string('nama_pelanggan')->nullable();
            $table->string('telp_pelanggan')->nullable();
            $table->string('email_pelanggan')->nullable();
            $table->string('password_pelanggan')->nullable();
            $table->string('password_reset_token')->nullable();
            $table->text('foto_pelanggan')->nullable();
            $table->string('role_pelanggan', 20)->default('pembeli');
            $table->string('status_pelanggan', 11)->default('Aktif');
            $table->timestamp('created_pelanggan')->useCurrent();
            $table->timestamp('updated_pelanggan')->nullable()->nullable()->default(null);
            $table->string('delete_pelanggan', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pelanggan');
    }
}
