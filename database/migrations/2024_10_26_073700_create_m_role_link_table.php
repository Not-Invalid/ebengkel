<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMRoleLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_role_link', function (Blueprint $table) {
            $table->integer('id_role_link')->primary();
            $table->integer('id_role');
            $table->integer('id_menu');
            $table->integer('can_access')->default(0);
            $table->integer('can_create')->default(0);
            $table->integer('can_modify')->default(0);
            $table->integer('can_delete')->default(0);
            $table->integer('see_restricted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_role_link');
    }
}
