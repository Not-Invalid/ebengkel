<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_menu', function (Blueprint $table) {
            $table->integer('id_menu')->primary()->autoIncrement();
            $table->integer('parent_id_1')->nullable();
            $table->integer('parent_id_2')->nullable();
            $table->integer('parent_id_3')->nullable();
            $table->integer('menu_position')->nullable();
            $table->string('nama_menu', 30)->nullable();
            $table->string('link_menu')->nullable();
            $table->string('icon_menu', 50)->nullable();
            $table->string('menu_type', 20)->nullable();
            $table->string('input_by', 50)->nullable();
            $table->dateTime('input_date')->nullable();
            $table->string('update_by', 50)->nullable();
            $table->dateTime('update_date')->nullable();
            $table->string('delete_by', 50)->nullable();
            $table->dateTime('delete_date')->nullable();
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
        Schema::dropIfExists('m_menu');
    }
}
