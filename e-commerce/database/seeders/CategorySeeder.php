<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Casual', 'slug' => 'casual', 'type' => 'T-shirts'],
            ['name' => 'Formal', 'slug' => 'formal', 'type' => 'Shirts'],
            ['name' => 'Gym', 'slug' => 'gym', 'type' => 'Shorts'],
            ['name' => 'Party', 'slug' => 'party', 'type' => 'Hoodie'],
            ['name' => 'Denim', 'slug' => 'denim', 'type' => 'Jeans'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
