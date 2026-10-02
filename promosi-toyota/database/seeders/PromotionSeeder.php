<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use App\Models\Showroom;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            // Featured Models
            [
                'title' => 'Kijang Innova Zenix',
                'description' => 'Cross into the new energy with bold design and advanced tech.',
                'image' => 'zenix1.png',
                'featured' => true,
            ],
            [
                'title' => 'Toyota Avanza Veloz',
                'description' => 'Refined design, modern features, and improved efficiency.',
                'image' => 'veloz.png',
                'featured' => true,
            ],
            [
                'title' => 'All New Toyota GR86',
                'description' => 'Bred from racing DNA, built for pure driving excitement.',
                'image' => 'gr.png',
                'featured' => true,
            ],
            [
                'title' => 'Toyota Vellfire',
                'description' => 'Premium MPV with luxurious cabin and bold, modern styling.',
                'image' => 'vellfire.png',
                'featured' => true,
            ],
            [
                'title' => 'Toyota GR Yaris',
                'description' => 'The rally-inspired hot hatch for pure performance driving.',
                'image' => 'yaris.jpeg',
                'featured' => true,
            ],
            [
                'title' => 'Toyota Supra',
                'description' => 'The iconic sports car reborn with exhilarating power and design.',
                'image' => 'supra.png',
                'featured' => true,
            ],

            // Models
            [
                'title' => 'Kijang Innova',
                'description' => 'The early generation MPV with legendary reliability.',
                'image' => 'innova.png',
                'featured' => false,
            ],
            [
                'title' => 'Kijang Innova Reborn',
                'description' => 'Improved performance and modern comfort in one package.',
                'image' => 'reborn.png',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Avanza',
                'description' => 'Iconic affordable MPV beloved by many families in Indonesia.',
                'image' => 'avanza-lama.png',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Corolla',
                'description' => 'A global icon known for reliability, comfort, and style.',
                'image' => 'corolla.jpg',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Rush',
                'description' => 'A rugged and spacious SUV designed for adventure.',
                'image' => 'rush.png',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Agya',
                'description' => 'A compact and fuel-efficient city car perfect for urban driving.',
                'image' => 'agya.png',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Raize',
                'description' => 'A stylish compact SUV that’s fun to drive and easy to handle.',
                'image' => 'raize.jpg',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Camry',
                'description' => 'A refined sedan offering premium comfort and advanced safety.',
                'image' => 'camry.png',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Alphard',
                'description' => 'Experience first-class travel with unrivaled comfort.',
                'image' => 'alphard.jpg',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Fortuner',
                'description' => 'Powerful SUV with dependable performance on and off the road.',
                'image' => 'fortuner.png',
                'featured' => false,
            ],
            [
                'title' => 'Toyota Vios',
                'description' => 'Compact sedan designed for efficiency and everyday practicality.',
                'image' => 'vios.jpg',
                'featured' => false,
            ],
        ];

        foreach ($cars as $car) {
            $showroom = Showroom::where('title', $car['title'])->first();

if ($showroom) {
    Promotion::create([
        'title'  => $car['title'],
        'description' => $car['description'],
        'image'       => $car['image'],
        'featured'    => $car['featured'],
        'specs'       => $showroom->specs,
        'showroom_id' => $showroom->id,
    ]);
        }
    }
}
}