<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        // Jika tidak ada data user atau produk, seeder tidak jalan
        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No users or products found. Seeder skipped.');
            return;
        }

        foreach ($users as $user) {
            // Buat 2 order per user
            for ($i = 0; $i < 2; $i++) {
                $statuses = ['pending', 'processed', 'shipped', 'completed'];
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => 0, // Akan dihitung dari item
                    'payment_method' => 'bank_transfer',
                    'shipping_address' => 'Jl. Contoh No. ' . rand(1, 100),
                    'nama_rekening' => $user->name,
                    'bukti_transfer' => 'bukti' . Str::random(5) . '.jpg',
                    'status' => $statuses[array_rand($statuses)],
                ]);

                $total = 0;

                // Tambahkan 1–3 item dalam order ini
                $itemCount = rand(1, 3);
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 5);
                    $price = $product->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $total += $price * $quantity;
                }

                $order->update(['total_price' => $total]);
            }
        }
    }
}
