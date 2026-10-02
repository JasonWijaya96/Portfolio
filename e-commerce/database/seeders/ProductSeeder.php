<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Gradient Graphic T-shirt #1',
                'slug' => 'gradient-graphic-t-shirt-1',
                'description' => 'Auto-generated description for Gradient Graphic T-shirt #1.',
                'price' => 35.95, 
                'original_price' => 60.00,
                'discount_type' => 'percent',
                'discount_value' => 40,
                'on_sale' => true,
                'stock' => 5,
                'image' => 'products/image2.jpg',
                'color' => 'purple',
                'size' => 'S,M,L',
                'style' => 'Casual',
                'type' => 'T-shirts',
                'category_id' => 3,
                'user_id' => 1,
                'brand_id' => 1
            ],
            [
                'name' => 'Classic Denim Shirts',
                'slug' => 'classic-denim-shirts',
                'description' => 'Timeless denim jacket suitable for all seasons.',
                'price' => 59.99, 
                'original_price' => 85.00,
                'discount_type' => 'percent',
                'discount_value' => 25.01,
                'on_sale' => true,
                'stock' => 10,
                'image' => 'products/image3.jpg',
                'color' => 'blue',
                'size' => 'M,L,XL',
                'style' => 'Formal',
                'type' => 'Shirts',
                'category_id' => 2,
                'user_id' => 1,
                'brand_id' => 2
            ],
            [
                'name' => 'Athletic Fit Shorts',
                'slug' => 'athletic-fit-shorts',
                'description' => 'Comfortable joggers perfect for workouts or lounging.',
                'price' => 42.50, 
                'original_price' => 50.00,
                'discount_type' => 'percent',
                'discount_value' => 15,
                'on_sale' => true,
                'stock' => 8,
                'image' => 'products/image4.jpg',
                'color' => 'gray',
                'size' => 'S,M,L,XL',
                'style' => 'Gym',
                'type' => 'Shorts',
                'category_id' => 4,
                'user_id' => 1,
                'brand_id' => 3
            ],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }
    }
}
