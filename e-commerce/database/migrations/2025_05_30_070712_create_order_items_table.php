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
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users');
    $table->decimal('total_price', 12, 2);
    $table->string('payment_method');
    $table->text('shipping_address');
    $table->string('nama_rekening')->nullable();
    $table->string('bukti_transfer')->nullable();
    $table->enum('status', ['pending', 'processed', 'shipped', 'completed'])->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
