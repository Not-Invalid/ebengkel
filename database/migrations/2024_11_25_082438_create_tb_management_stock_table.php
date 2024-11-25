<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbManagementStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_management_stock', function (Blueprint $table) {
            $table->id('id_stock'); // Primary key
            $table->integer('id_bengkel'); // Foreign key, unsigned integer
            $table->unsignedInteger('id_produk'); // Foreign key, unsigned integer
            $table->integer('quantity'); // Quantity field
            $table->text('description')->nullable(); // Description field

            // Relasi dengan tb_bengkel dan tb_produk
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('tb_produk')->onDelete('cascade');

            $table->timestamps(false); // Disable timestamps (created_at, updated_at) as per model settings
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_management_stock');
    }
}
