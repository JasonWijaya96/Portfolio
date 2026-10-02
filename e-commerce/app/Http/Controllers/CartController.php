<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan keranjang
    public function index()
    {
        $cart   = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items  = $cart->items()->with('product')->get();

        return view('cart.index', compact('cart', 'items'));
    }

    // Simpan ke database saat tombol "Add to Cart" ditekan
    public function add(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
        'size'       => 'required|string',
    ]);

    $product = Product::findOrFail($request->product_id);
    $cart    = Cart::firstOrCreate(['user_id' => Auth::id()]);

    // Cari item yang sama PADA CART yang punya SIZE YANG SAMA via session / hash
    $size = $request->input('size');

    // Ambil semua item di cart
   $existingItem = $cart->items()->where('product_id', $product->id)
    ->where('size', $size)
    ->first();


    if ($existingItem) {
        $existingItem->increment('quantity', $request->quantity);
    } else {
        $cart->items()->create([
    'product_id' => $product->id,
    'quantity'   => $request->quantity,
    'size'       => $size,
]);

    }

    return redirect()->route('cart.index')->with('success', 'Product added to cart!');
}


    // Hapus item
    public function remove(CartItem $cartItem)
    {
        if (Auth::id() !== $cartItem->cart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $cartItem->delete();
        return back()->with('success', 'Item removed.');
    }

    // + / - quantity
    public function updateQty(CartItem $cartItem, $action)
    {
        if (Auth::id() !== $cartItem->cart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($action === 'increase') {
            $cartItem->increment('quantity');
        }

        if ($action === 'decrease' && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }

        return back();
    }
}