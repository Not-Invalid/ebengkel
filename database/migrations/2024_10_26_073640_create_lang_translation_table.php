<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLangTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lang_translation', function (Blueprint $table) {
            $table->integer('id')->primary()->autoIncrement();
            $table->string('lang', 10)->nullable();
            $table->string('keyword', 5000);
            $table->string('translations', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lang_translation');
    }
}
