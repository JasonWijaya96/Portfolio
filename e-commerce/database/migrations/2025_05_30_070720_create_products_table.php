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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->enum('discount_type', ['percent', 'fixed'])->nullable();
            $table->integer('discount_value')->nullable();
            $table->boolean('on_sale')->default(false);
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();


            // ✅ Filterable Fields
            $table->string('color')->nullable();   // 🎨 warna
            $table->string('size')->nullable();    // 👕 ukuran
            $table->string('style')->nullable();   // 🧍‍♂️ dress style: Casual, Gym, etc
            $table->string('type')->nullable();    // 🧥 jenis produk: T-shirts, Shorts, etc

            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('user_id')->constrained('users'); // seller
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');

            $table->unsignedBigInteger('sales')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
