@extends('layouts.default')

@section('title', 'On Sale')

@section('content')
<div class="container mx-auto px-4 py-10">

        <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="list-reset flex">
            <li>
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <span class="mx-2">></span>
            </li>
            <li class="text-black font-semibold">
                on sale {{-- Diubah dari "brand" menjadi "Brands" agar lebih baik --}}
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl font-bold mb-6">🔥 On Sale Products</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
            {{-- Panggil komponen card --}}
            @include('components.product-card-discount', ['product' => $product])
        @empty
            <p class="col-span-full text-gray-500">No discounted products found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $products->links('vendor.pagination.shopco') }}
    </div>
</div>
@endsection
