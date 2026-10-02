<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // Pastikan model Product di-import
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Pastikan DB facade di-import

class BillingController extends Controller
{
    public function index()
    {
        $cart = \App\Models\Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjangmu kosong!');
        }

        $cartItems = $cart->items;

        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $shipping = 0; // Anda mungkin punya logika untuk menghitung ini
        $total = $subtotal + $shipping;

        return view('billing.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Simpan pesanan ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
/*******  30e5c41a-33f2-44d7-8399-1ee51fd1287e  *******/    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'payment_method' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required|string',
            'bank_tujuan' => 'nullable|string',
            'nama_rekening' => 'nullable|string',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->payment_method === 'bank') {
            if (!$request->bank_tujuan || !$request->nama_rekening || !$request->hasFile('bukti_transfer')) {
                return back()->withErrors(['payment' => 'Mohon isi semua informasi pembayaran bank.'])->withInput();
            }
        }

        // --- Start Server-Side Cart & Price Re-validation ---
        // Sangat penting untuk keamanan dan akurasi
        $cart = \App\Models\Cart::with('items.product')->where('user_id', auth()->id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->withErrors(['cart' => 'Keranjangmu kosong!'])->withInput();
        }

        $calculatedSubtotal = $cart->items->sum(fn ($item) => $item->product->price * $item->quantity);
        $calculatedShipping = 0; // Sesuaikan jika ada logika shipping
        $calculatedTotalPrice = $calculatedSubtotal + $calculatedShipping;

        // Logika kupon (jika ada, hitung ulang diskonnya di server-side)
        $coupon = null;
        $couponCode = $request->input('coupon_code');
        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', strtoupper($couponCode))
                ->whereDate('expires_at', '>=', now())
                ->first();

            if ($coupon && auth()->user()->coupons()->where('coupon_id', $coupon->id)->wherePivot('used', false)->exists()) {
                $discount = $coupon->discount;
                $calculatedTotalPrice = max(0, $calculatedTotalPrice - $discount);
            } else {
                // Kupon tidak valid atau sudah digunakan, jangan terapkan diskon
                $coupon = null; // Reset variable coupon agar tidak ditandai 'used'
                // Anda bisa tambahkan pesan error kupon tidak valid di sini jika ingin
            }
        }
        // --- End Server-Side Cart & Price Re-validation ---


        // *** MULAI TRANSAKSI DATABASE ***
        DB::beginTransaction();

        try {
            // 1. Buat Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $calculatedTotalPrice, // Gunakan harga yang sudah dihitung ulang di server
                'payment_method' => $request->input('payment_method') === 'bank'
                    ? $request->input('bank_tujuan')
                    : $request->input('payment_method'),
                'shipping_address' => $request->input('address'),
                // 'nama_rekening' dan 'bukti_transfer' hanya diisi jika payment_method adalah 'bank'
                'nama_rekening' => ($request->input('payment_method') === 'bank') ? $request->input('nama_rekening') : null,
                'bukti_transfer' => ($request->input('payment_method') === 'bank' && $request->hasFile('bukti_transfer'))
                    ? $request->file('bukti_transfer')->storeAs(
                        'bukti_transfer',
                        $request->file('bukti_transfer')->getClientOriginalName(),
                        'public'
                    )
                    : null,
                'status' => 'pending', // Status awal pesanan
            ]);

            // 2. Tandai kupon sebagai sudah digunakan (jika kupon valid dan diterapkan)
            if ($coupon) {
                auth()->user()->coupons()->updateExistingPivot($coupon->id, ['used' => true]);
            }

            // 3. Iterasi setiap item di keranjang untuk membuat OrderItem, mengupdate sales, dan DECREMENT STOK
            foreach ($cart->items as $item) {
    $product = Product::lockForUpdate()->find($item->product->id);

    // Validasi stok sebelum melanjutkan
    if (!$product || $product->stock < $item->quantity) {
        DB::rollBack(); // Batalkan seluruh transaksi
        return back()->with('error', 'Stok produk "' . ($product->name ?? 'Unknown Product') . '" tidak mencukupi. Sisa stok: ' . ($product->stock ?? 0) . '.')->withInput();
    }

    // Buat OrderItem dan sertakan ukuran
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => $item->quantity,
        'price' => $product->price,
        'size' => $item->size,  // Menyimpan ukuran produk yang dipilih
    ]);

    // Mengupdate penjualan dan stok
    $product->increment('sales', $item->quantity);
    $product->decrement('stock', $item->quantity);
}

            // 4. Hapus keranjang setelah semua item berhasil diproses
            $cart->items()->delete(); // Hapus item-item di keranjang
            $cart->delete(); // Hapus keranjang itu sendiri

            // *** KOMIT TRANSAKSI JIKA SEMUA OPERASI DI ATAS BERHASIL ***
            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            // *** ROLLBACK TRANSAKSI JIKA TERJADI ERROR APAPUN ***
            DB::rollBack();
            // Log error untuk debugging yang lebih baik
            \Log::error('Order processing failed: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.')->withInput();
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            // 'total_price' dari frontend tidak terlalu relevan di sini karena kita akan hitung ulang
        ]);

        $couponCode = strtoupper($request->coupon_code);
        
        // Ambil ulang cart untuk menghitung subtotal asli dari server
        $cart = \App\Models\Cart::with('items.product')->where('user_id', auth()->id())->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Keranjangmu kosong!'], 422);
        }
        $subtotalFromCart = $cart->items->sum(fn ($item) => $item->product->price * $item->quantity);

        $coupon = \App\Models\Coupon::where('code', $couponCode)
            ->whereDate('expires_at', '>=', now())
            ->first();

        // Check if the user has this coupon and it hasn't been used
        if (!$coupon || !auth()->user()->coupons()->where('coupon_id', $coupon->id)->wherePivot('used', false)->exists()) {
            return response()->json(['error' => 'Kupon tidak valid atau sudah digunakan'], 422);
        }

        $discount = $coupon->discount;
        // Hitung total setelah diskon dari subtotal yang dihitung server-side
        $totalAfterDiscount = max(0, $subtotalFromCart - $discount);

        return response()->json([
            'discount' => $discount,
            'total' => $totalAfterDiscount,
            'message' => 'Kupon berhasil diterapkan!',
        ]);
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return view('billing.show', compact('order'));
    }

    public function orderHistory()
{
    // Mengambil SEMUA pesanan milik user, menghasilkan COLLECTION
     $orders = Auth::user()->orders()->latest()->paginate(10);

    return view('billing.order_history', compact('orders'));
}
}