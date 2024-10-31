<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDocumentHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_document_history', function (Blueprint $table) {
            $table->integer('id_document_history')->primary()->autoIncrement();
            $table->integer('id_karyawan')->nullable();
            $table->integer('id_content')->nullable();
            $table->string('type_content', 30)->nullable();
            $table->string('action', 15)->nullable();
            $table->string('description')->nullable();
            $table->text('details')->nullable();
            $table->dateTime('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_document_history');
    }
}
