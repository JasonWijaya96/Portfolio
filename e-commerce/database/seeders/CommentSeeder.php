<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::create([
            'user_id' => 3,
            'product_id' => 1,
            'content' => 'Produk bagus banget, kualitas oke dan pengiriman cepat!',
            'rating' => 5,
        ]);

        Comment::create([
            'user_id' => 4,
            'parent_id' => 1, // Reply ke komentar pertama
            'content' => 'makasih atas reviewnya yah kak :D',
        ]);

        Comment::create([
            'user_id' => 3,
            'product_id' => 2,
            'content' => 'Produk bagus banget, kualitas oke',
            'rating' => 3,
        ]);

        Comment::create([
            'user_id' => 3,
            'product_id' => 3,
            'content' => 'Produk terlalu kecil, tidak sesuai ekspektasi',
            'rating' => 2,
        ]);

    }
}