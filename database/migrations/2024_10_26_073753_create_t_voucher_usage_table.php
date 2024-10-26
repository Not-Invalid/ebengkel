<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTVoucherUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_voucher_usage', function (Blueprint $table) {
            $table->integer('id_voucher_usage')->primary();
            $table->integer('id_voucher');
            $table->integer('id_order');
            $table->dateTime('usage_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_voucher_usage');
    }
}
