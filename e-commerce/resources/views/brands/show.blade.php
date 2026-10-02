@extends('layouts.default')

@section('title', 'Brand: ' . $brand->name) {{-- Title halaman yang lebih spesifik --}}

@section('content')
<div class="container mx-auto px-4 py-10">

    {{-- 1. Breadcrumb diperbaiki dengan hierarki yang benar --}}
    <nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
        <ol class="list-reset flex items-center">
            <li>
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
            </li>
            <li>
                <span class="mx-2">></span>
            </li>
            <li>
                <a href="{{ route('brands.index') }}" class="hover:underline">Brands</a>
            </li>
            <li>
                <span class="mx-2">></span>
            </li>
            <li class="text-black font-semibold">
                {{ $brand->name }}
            </li>
        </ol>
    </nav>

    {{-- 2. Judul lebih informatif dengan jumlah produk --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold">{{ $brand->name }}</h2>
        <p class="text-gray-500">
            Showing {{ $products->total() }} products from this brand.
        </p>
    </div>
    
    {{-- 3. Menggunakan @forelse untuk menangani jika tidak ada produk --}}
    {{-- 4. Grid dibuat lebih responsif untuk layar besar (lg) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
            @include('categories._product-card', ['product' => $product])
        @empty
            {{-- Pesan yang ditampilkan jika tidak ada produk --}}
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No products found for this brand yet.</p>
            </div>
        @endforelse
    </div>

    {{-- 5. Menambahkan Pagination --}}
    <div class="mt-12">
        {{ $products->links('vendor.pagination.shopco') }}
    </div>

</div>
@endsection