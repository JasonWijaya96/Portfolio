@extends('layouts.default')

@section('title', 'Order Details')

@section('content')
<div class="max-w-3xl mx-auto px-4 md:px-0 py-12">
    


    <h2 class="text-3xl font-semibold mb-6 text-center md:text-left">Order Details</h2>

    <nav class="max-w-7xl mx-auto px-4 text-sm text-gray-500 mb-6 mt-12" aria-label="Breadcrumb">
    <ol class="list-reset flex">
        <li>
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <span class="mx-2">></span>
        </li>
        <li>
            <a href="{{ route('orders.index') }}" class="hover:underline">Orders</a>
            <span class="mx-2">></span>
        </li>
                <li class="text-black font-semibold">
            Order Details
        </li>
    </ol>
</nav>


    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4 text-center md:text-left">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow">
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Status:</strong> <span class="font-semibold text-yellow-600">{{ ucfirst($order->status) }}</span></p>
        <p><strong>Total:</strong> ${{ $order->total_price }}</p>
        <p>
            <strong>Payment Method:</strong>
            @if (in_array($order->payment_method, ['BCA', 'BNI', 'Mandiri']))
                Bank {{ $order->payment_method }}
            @else
                {{ $order->payment_method }}
            @endif
        </p>
        <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>

        <hr class="my-4">

        <h3 class="text-lg font-semibold mb-2">Items:</h3>
<ul class="space-y-4">
    @foreach($order->items as $item)
        <li class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-4">
            <div class="flex items-start sm:items-center gap-4">
                <img src="{{ asset($item->product->image) }}" 
                     alt="{{ $item->product->name }}" 
                     class="w-16 h-16 object-cover rounded" />
                <div>
                    <p class="font-medium">{{ $item->product->name }}</p>
                    <p class="text-sm text-gray-600">× {{ $item->quantity }}</p>
                    
                    {{-- Tampilkan Ukuran Produk --}}
                    @if($item->size)
                        <p class="text-sm text-gray-500">Size: {{ $item->size }}</p>
                    @endif
                </div>
            </div>
            <span class="font-semibold text-right sm:text-left">${{ $item->price * $item->quantity }}</span>
        </li>
    @endforeach
</ul>

        <div class="mt-6 text-center md:text-left">
            <a href="{{ route('categories.index') }}"
   class="inline-flex items-center justify-center gap-2 px-6 py-3 w-full sm:w-auto text-base font-semibold text-white bg-gradient-to-r from-gray-900 to-gray-700 rounded-lg shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-300 active:scale-95">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back to Shop
</a>
        </div>
    </div>
</div>
@endsection
