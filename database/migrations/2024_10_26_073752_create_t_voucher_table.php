<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_voucher', function (Blueprint $table) {
            $table->integer('id_voucher')->primary();
            $table->string('voucher_code', 50);
            $table->integer('id_customer')->nullable();
            $table->enum('voucher_type', ['ALL', 'MEMBER', 'SPECIFIC', ''])->default('');
            $table->integer('voucher_max_usage')->default(99999);
            $table->integer('voucher_usage')->default(0);
            $table->integer('voucher_nominal');
            $table->enum('voucher_discount_type', ['NOMINAL', 'PERCENTAGE']);
            $table->integer('min_transaction')->default(0);
            $table->date('expired_date')->nullable();
            $table->string('is_active', 1)->default('Y');
            $table->string('input_by', 50);
            $table->dateTime('input_date')->useCurrent();
            $table->string('is_delete', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_voucher');
    }
}
