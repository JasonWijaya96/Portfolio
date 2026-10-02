<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'DISKON50',
                'discount' => 50,
                'expires_at' => Carbon::now()->addDays(10),
            ],
            [
                'code' => 'DISKON20',
                'discount' => 20,
                'expires_at' => Carbon::now()->addDays(10),
            ],
            [
                'code' => 'SHOPCOMERS',
                'discount' => 30,
                'expires_at' => Carbon::now()->addDays(5),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(['code' => $coupon['code']], $coupon);
        }
    }
}
