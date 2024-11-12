<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_peserta_event', function (Blueprint $table) {
            $table->id('id_peserta');
            $table->integer('event_id'); // Ensure this matches the type in tb_event
            $table->string('nama_peserta');
            $table->string('email')->nullable();
            $table->string('no_telepon')->nullable();
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->string('payment_status', 1)->default('N');
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('event_id')->references('id_event')->on('tb_event')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_peserta_event');
    }
};
