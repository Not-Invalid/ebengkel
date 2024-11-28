<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbManagementStockInboundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_management_stock_inbound', function (Blueprint $table) {
            $table->id('id_stock');
            $table->integer('id_bengkel');
            
            // New column to store employee who inputs the stock
            $table->integer('id_pegawai')->nullable(true);
            
            $table->unsignedInteger('id_produk')->nullable(true); // Nullable for the sake of optional relationships
            $table->integer('id_spare_part')->nullable(true); // Nullable for the sake of optional relationships
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->enum('type', ['product', 'spare_part']);
    
            // Foreign keys
            $table->foreign('id_bengkel')->references('id_bengkel')->on('tb_bengkel')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('tb_produk')->onDelete('cascade');
            $table->foreign('id_spare_part')->references('id_spare_part')->on('tb_spare_part')->onDelete('cascade');
            
            // Foreign key for the employee (pegawai)
            $table->foreign('id_pegawai')->references('id_pegawai')->on('tb_pegawai')->onDelete('cascade');
            
            $table->timestamps(false);
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_management_stock_inbound');
    }
}
