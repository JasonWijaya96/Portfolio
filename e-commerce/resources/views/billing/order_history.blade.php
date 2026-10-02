@extends('layouts.default')

@section('title', 'Riwayat Pesanan Saya')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <nav class="mb-8 text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                    <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li class="flex items-center">
                    <a href="#" class="text-gray-500 hover:text-gray-700">My Account</a>
                     <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                </li>
                <li class="text-gray-800 font-semibold">
                    My Orders
                </li>
            </ol>
        </nav>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 text-gray-900">
                <h2 class="text-2xl font-bold mb-6">Riwayat Pesanan Anda</h2>

                <div class="space-y-6">
                    @forelse($orders as $order)
                        {{-- Logika untuk warna status dinamis --}}
                        @php
                            $statusClass = '';
                            switch (strtolower($order->status)) {
                                case 'completed':
                                    $statusClass = 'bg-green-100 text-green-800';
                                    break;
                                case 'processing':
                                    $statusClass = 'bg-blue-100 text-blue-800';
                                    break;
                                case 'pending':
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    break;
                                case 'cancelled':
                                case 'refunded':
                                    $statusClass = 'bg-red-100 text-red-800';
                                    break;
                                default:
                                    $statusClass = 'bg-gray-100 text-gray-800';
                            }
                        @endphp

                        <div class="border border-gray-200 rounded-lg p-4 transition hover:shadow-md">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                                {{-- Info Utama Pesanan --}}
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-500">Order ID: <span class="font-semibold text-gray-800">#{{ $order->id }}</span></p>
                                    <p class="text-sm text-gray-500">Tanggal: <span class="text-gray-800">{{ $order->created_at->format('d F Y') }}</span></p>
                                    {{-- 5. Perbaikan format harga --}}
                                    <p class="text-lg font-bold text-black">${{ number_format($order->total_price, 2, '.', ',') }}</p>
                                </div>
                                
                                {{-- Status dan Tombol Aksi --}}
                                <div class="flex flex-col sm:items-end sm:text-right gap-3">
                                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <a href="{{ route('orders.show', $order->id) }}" class="text-sm font-semibold text-black hover:underline">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </div>

                            {{-- Ringkasan Item --}}
                             @if($order->items->isNotEmpty())
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($order->items->take(4) as $item)
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name ?? '' }}" class="w-12 h-12 object-cover rounded-md border" title="{{ $item->product->name ?? '' }} (x{{ $item->quantity }})" />
                                            @endif
                                        @endforeach
                                        @if($order->items->count() > 4)
                                            <div class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center text-xs font-semibold text-gray-500 border">
                                                +{{ $order->items->count() - 4 }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-10 border-2 border-dashed rounded-lg">
                            <p class="text-gray-500">Anda belum memiliki riwayat pesanan.</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-block px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800">Mulai Belanja</a>
                        </div>
                    @endforelse
                </div>
                
                {{-- Pagination Links --}}
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection     