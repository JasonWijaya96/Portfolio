<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'seller',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            CommentSeeder::class,
            CouponSeeder::class,
            OrderSeeder::class,
        ]);

        $user = \App\Models\User::where('email', 'user123@example.com')->first();
        $coupons = \App\Models\Coupon::all();

        if ($user) {
            foreach ($coupons as $coupon) {
                $user->coupons()->syncWithoutDetaching([
                    $coupon->id => ['used' => false],
                ]);
            }
        }

        User::factory(10)->create();
    }

}
