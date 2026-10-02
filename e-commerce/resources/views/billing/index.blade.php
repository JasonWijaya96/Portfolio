@extends('layouts.default')

@section('title', 'Checkout')

@section('content')
<div class="bg-gray-50 font-sans">

    {{-- Notifikasi Sukses (jika ada setelah submit) --}}
    @if (session('success'))
        <div x-data="{ open: true }" x-init="setTimeout(() => open = false, 3000)" x-show="open" x-transition class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-black bg-opacity-50 absolute inset-0"></div>
            <div class="bg-white rounded-lg shadow-lg p-6 z-10 w-96 text-center">
                <h2 class="text-2xl font-bold text-green-600 mb-2">Success!</h2>
                <p class="text-gray-800">{{ session('success') }}</p>
                <button @click="open = false" class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Close</button>
            </div>
        </div>
    @endif

    {{-- Kontainer utama yang terpusat --}}
    <div class="container mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="list-reset flex items-center">
                <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                <li><span class="mx-2">></span></li>
                <li><a href="{{ route('cart.index') }}" class="hover:underline">Cart</a></li>
                <li><span class="mx-2">></span></li>
                <li class="text-black font-semibold">Checkout</li>
            </ol>
        </nav>

        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            
            <h2 class="mt-10 text-3xl font-medium tracking-wide text-black">Billing Details</h2>

            <div class="mt-8 grid grid-cols-1 gap-y-12 md:grid-cols-2 md:gap-x-12 xl:gap-x-24">
                
                {{-- KOLOM KIRI: FORM INPUT --}}
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" required value="{{ old('name', auth()->user()->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-12 px-4 focus:border-black focus:ring-black">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Street Address <span class="text-red-500">*</span></label>
                        <input type="text" id="address" name="address" required value="{{ old('address') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-12 px-4 focus:border-black focus:ring-black">
                    </div>
                    <div>
                        <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment, floor, etc. (optional)</label>
                        <input type="text" id="apartment" name="apartment" value="{{ old('apartment') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-12 px-4 focus:border-black focus:ring-black">
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Town / City <span class="text-red-500">*</span></label>
                        <input type="text" id="city" name="city" required value="{{ old('city') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-12 px-4 focus:border-black focus:ring-black">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" id="phone" name="phone" required value="{{ old('phone', auth()->user()->phone ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-12 px-4 focus:border-black focus:ring-black">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required value="{{ old('email', auth()->user()->email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-12 px-4 focus:border-black focus:ring-black">
                    </div>
                </div>

                {{-- KOLOM KANAN: ORDER SUMMARY & PAYMENT --}}
                <div class="space-y-6">
                    {{-- Order Summary --}}
                    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Order Summary</h3>
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset($item['product']->image) }}" alt="{{ $item['product']->name }}" class="h-16 w-16 rounded-md object-cover">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $item['product']->name }}</p>
                                            <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>

                                            {{-- Menampilkan Ukuran (Size) --}}
                                            @if (isset($item['size']))  {{-- Cek apakah size ada --}}
                                                <p class="text-sm text-gray-500">Size: {{ $item['size'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="font-medium">${{ number_format($item['product']->price * $item['quantity'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 space-y-2 border-t border-gray-200 pt-4 text-sm">
                            <div class="flex items-center justify-between">
                                <p class="text-gray-600">Subtotal</p>
                                <p class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-gray-600">Shipping</p>
                                <p class="font-medium text-gray-900">{{ $shipping == 0 ? 'Free' : '$' . number_format($shipping, 2) }}</p>
                            </div>
                            {{-- Baris untuk diskon, ditampilkan via JS --}}
                            <div class="flex items-center justify-between hidden" id="discount-row">
                                <p class="text-gray-600" id="discount-label">Discount</p>
                                <p class="font-medium text-red-500" id="discount-amount"></p>
                            </div>
                            <div class="flex items-center justify-between !mt-4 border-t border-gray-200 pt-4 text-base font-medium">
                                <p>Total</p>
                                <p id="total-amount">${{ number_format($total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                        
                    {{-- Hidden inputs for calculation --}}
                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                    <input type="hidden" name="total_price" id="total-hidden" value="{{ $total }}">
                    <input type="hidden" name="discount" id="discount-hidden" value="0">

                    {{-- Payment Method --}}
                    <div x-data="{ paymentMethod: 'cod' }" class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Payment Method</h3>
                        <div class="space-y-4 rounded-md border border-gray-200 bg-white p-4">
                                <div class="flex items-center"><input @click="paymentMethod = 'bank'" type="radio" id="bank" name="payment_method" value="bank" class="h-4 w-4 border-gray-300 text-black focus:ring-black"><label for="bank" class="ml-3 block text-sm font-medium text-gray-700">Bank Transfer</label></div>
                                <div class="flex items-center"><input @click="paymentMethod = 'cod'" type="radio" id="cash" name="payment_method" value="Cash on Delivery" checked class="h-4 w-4 border-gray-300 text-black focus:ring-black"><label for="cash" class="ml-3 block text-sm font-medium text-gray-700">Cash on Delivery</label></div>
                        </div>
                        <div x-show="paymentMethod === 'bank'" x-transition class="space-y-4 rounded-md border border-gray-200 bg-white p-4">
                            <div><label for="bank_tujuan" class="block text-sm font-medium text-gray-700">Pilih Bank Tujuan</label><select name="bank_tujuan" id="bank_tujuan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black" :required="paymentMethod === 'bank'"><option value="">-- Pilih Rekening --</option><option value="BCA">BCA - 1234567890 (PT SHOP.CO)</option></select></div>
                            <div><label for="nama_rekening" class="block text-sm font-medium text-gray-700">Nama Pemilik Rekening</label><input type="text" name="nama_rekening" id="nama_rekening" placeholder="Nama sesuai bukti transfer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-2" :required="paymentMethod === 'bank'"></div>
                            <div><label for="bukti_transfer" class="block text-sm font-medium text-gray-700">Upload Bukti Transfer</label><input type="file" name="bukti_transfer" id="bukti_transfer" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-gray-100 file:font-semibold hover:file:bg-gray-200" :required="paymentMethod === 'bank'"></div>
                        </div>
                    </div>
                    
                    {{-- Coupon Code --}}
                    <div class="flex items-end gap-4">
                        <div class="flex-grow">
                            <label for="coupon_code" class="sr-only">Coupon Code</label>
                            <input type="text" id="coupon_code" name="coupon_code" placeholder="Coupon Code"
class="h-14 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black px-4"
value="{{ old('coupon_code') }}">
                        </div>
                        <button type="button" id="applyCouponBtn" class="h-14 shrink-0 rounded-md bg-black px-6 text-sm font-medium text-white shadow-sm hover:bg-gray-800">Apply Coupon</button>
                    </div>
                    @error('coupon_code')<p class="text-red-500 text-sm -mt-8">{{ $message }}</p>@enderror

                    <button type="submit" class="w-full rounded-md border border-transparent bg-black px-6 py-4 text-base font-medium text-white shadow-sm hover:bg-gray-800">Place Order</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyCouponBtn = document.getElementById('applyCouponBtn');
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function () {
            const couponInput = document.getElementById('coupon_code');
            const code = couponInput.value.trim();
            if (!code) {
                alert('Please enter a coupon code.');
                return;
            }

            const subtotal = parseFloat(document.querySelector('input[name="subtotal"]').value);
            const shipping = parseFloat(document.querySelector('input[name="shipping"]').value);
            const totalAmountEl = document.getElementById('total-amount');
            const totalHiddenEl = document.getElementById('total-hidden');
            const discountRowEl = document.getElementById('discount-row');
            const discountAmountEl = document.getElementById('discount-amount');
            const discountHiddenEl = document.getElementById('discount-hidden');

            fetch("{{ route('coupon.apply') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    coupon_code: code,
                    total_price: subtotal + shipping 
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                
                discountRowEl.classList.remove('hidden');
                discountAmountEl.innerText = `- $${parseFloat(data.discount).toFixed(2)}`;
                totalAmountEl.innerText = `$${parseFloat(data.total).toFixed(2)}`;
                discountHiddenEl.value = data.discount;
                totalHiddenEl.value = data.total;
                
                alert(data.message);
            })
            .catch(err => {
                alert(err.message || 'Failed to apply coupon.');
                // Reset tampilan jika kupon gagal
                discountRowEl.classList.add('hidden');
                totalAmountEl.innerText = `$${(subtotal + shipping).toFixed(2)}`;
                discountHiddenEl.value = 0;
                totalHiddenEl.value = subtotal + shipping;
            });
        });
    }
});
</script>
@endpush