<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_support_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_category_id')->constrained('tb_support_categories')->onDelete('cascade');
            $table->string('question');
            $table->text('answer');
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_support_info');
    }
};
