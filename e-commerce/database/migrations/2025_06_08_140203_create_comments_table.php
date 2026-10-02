<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Boleh null
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // ini kunci untuk reply
            $table->string('name')->nullable(); // Tambahkan name untuk guest
            $table->text('content');
            $table->unsignedTinyInteger('rating')->nullable(); // rating hanya untuk komentar utama
            $table->timestamps();

            $table->unique(['user_id', 'product_id'])->whereNull('parent_id'); // Batasi hanya 1 komentar utama per produk per user
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
