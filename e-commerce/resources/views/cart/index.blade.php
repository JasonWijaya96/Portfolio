@extends('layouts.default')

@section('content')

@php
    $subtotal = $items->sum(fn($i) => $i->product->price * $i->quantity);
    $discountPercent = 10;
    $discountAmount  = $subtotal * $discountPercent / 100;
    $total           = $subtotal - $discountAmount;
@endphp

{{-- Breadcrumb --}}
<nav class="max-w-7xl mx-auto px-4 text-sm text-gray-500 mb-6 mt-12" aria-label="Breadcrumb">
    <ol class="list-reset flex">
        <li>
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <span class="mx-2">></span>
        </li>
        <li class="text-black font-semibold">
            Cart
        </li>
    </ol>
</nav>

{{-- Main Content --}}
<div class="max-w-7xl mx-auto py-10 px-4 flex flex-col lg:flex-row gap-8">

    {{-- Kiri: Cart Items + Judul --}}
    <div class="flex-1">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">YOUR CART</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($items->isEmpty())
            <p class="text-gray-700">Your cart is empty.</p>
        @else
            @foreach ($items as $item)
                @php $product = $item->product; @endphp
                <div class="flex border rounded-xl overflow-hidden shadow-sm mb-6 mt-2 min-h-36">
                    {{-- Image --}}
                    <div class="w-32 h-full overflow-hidden">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 p-4 flex flex-col justify-between relative">
                        <form action="{{ route('cart.remove', $item) }}" method="POST" class="absolute top-2 right-2">
                            @csrf @method('DELETE')
                            <button class="text-gray-400 hover:text-red-600" title="Remove item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>

                        <div>
                            <h3 class="font-semibold text-lg text-gray-900">{{ $product->name }}</h3>
                            @if($item->size)
    <p class="text-sm text-gray-500">Size: {{ $item->size }}</p>
@endif

                            <p class="text-sm text-gray-600 truncate">{{ $product->description }}</p>
                        </div>

                        <div class="flex items-center justify-between mt-2">
                            <span class="font-bold text-gray-900">
                                ${{ number_format($product->price * $item->quantity, 2) }}
                            </span>

                            {{-- Qty control --}}
                            <div class="flex items-center border border-gray-300 rounded-full px-2 py-1">
                                <form action="{{ route('cart.update', [$item, 'decrease']) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="px-2">-</button>
                                </form>
                                <span class="px-3 select-none">{{ $item->quantity }}</span>
                                <form action="{{ route('cart.update', [$item, 'increase']) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="px-2">+</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Kanan: Order Summary --}}
    <div class="w-full lg:w-96 self-start p-6 bg-gray-100 rounded-xl flex flex-col gap-6 shadow-md">
        <h2 class="text-2xl font-bold">Order Summary</h2>

        <div class="flex justify-between text-gray-700">
            <span>Subtotal</span>
            <span>${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="flex justify-between text-gray-700">
            <span>Discount</span>
            <span>{{ $discountPercent }}%</span>
        </div>
        <div class="flex justify-between font-bold text-lg border-t border-gray-300 pt-2">
            <span>Total</span>
            <span>${{ number_format($total, 2) }}</span>
        </div>

        <a href="{{ route('checkout.index') }}" 
   class="bg-black text-white py-3 rounded text-lg hover:opacity-90 transition text-center block">
    Go to Checkout &rarr;
</a>
    </div>

</div>

@endsection