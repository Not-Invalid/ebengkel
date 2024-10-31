<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method', function (Blueprint $table) {
            $table->integer('id_payment')->primary()->autoIncrement();
            $table->string('bank_name', 150)->nullable();
            $table->string('inisial', 50)->nullable();
            $table->enum('type', ['MANUAL_TRANSFER', 'VIRTUAL_ACCOUNT', 'E_WALLET'])->default('MANUAL_TRANSFER');
            $table->string('type_transfer', 150)->nullable();
            $table->string('guide', 150)->nullable();
            $table->text('description')->nullable();
            $table->text('logo_payment')->nullable();
            $table->string('number_account', 150)->nullable();
            $table->string('name_account', 150)->nullable();
            $table->string('branch_account', 150)->nullable();
            $table->string('created_by', 150)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->dateTime('updated_dated')->nullable();
            $table->string('deleted_by', 150)->nullable();
            $table->dateTime('deleted_date')->nullable();
            $table->enum('is_deleted', ['Y', 'N'])->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_method');
    }
}
