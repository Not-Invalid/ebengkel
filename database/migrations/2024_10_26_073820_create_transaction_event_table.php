<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_event', function (Blueprint $table) {
            $table->integer('id_transaction_event')->primary();
            $table->integer('id_member_event')->nullable();
            $table->integer('id_event')->nullable();
            $table->integer('id_payment')->nullable();
            $table->string('payment_method', 150)->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('unique_code')->nullable();
            $table->integer('sum_price')->nullable();
            $table->enum('status', ['PAID', 'UNPAID', 'CANCEL'])->nullable();
            $table->text('image_transfer')->nullable();
            $table->string('account_bank_transfer', 150)->nullable();
            $table->string('account_name_transfer', 150)->nullable();
            $table->string('account_number_transfer', 22)->nullable();
            $table->integer('total_price_transfer')->nullable();
            $table->enum('status_transfer', ['APPROVED', 'REJECTED', 'DRAFT'])->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->dateTime('deleted_date')->nullable();
            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_date')->nullable();
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
        Schema::dropIfExists('transaction_event');
    }
}
