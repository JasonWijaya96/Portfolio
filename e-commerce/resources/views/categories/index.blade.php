@extends('layouts.default')

@section('title', isset($category) ? $category->name : ucfirst(request('style') ?? 'List of Fashion'))



@section('content')
<div class="flex flex-col lg:flex-row gap-6">



    {{-- Sidebar Filter (kotak putih rounded) --}}
    <aside class="w-full lg:w-1/4">
        <div class="bg-white p-6 rounded-xl shadow-sm">
            @include('categories._filters')
        </div>
    </aside>

    {{-- Produk Grid --}}
    <section class="w-full lg:w-3/4 pt-10">
        {{-- Header: Nama Kategori + Span Info + Sort --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-8">
          <h2 class="text-2xl font-bold">
    {{ request('style') ? ucfirst(request('style')) : 'List of Fashion' }}
</h2>


            <div class="flex items-center gap-3 text-sm text-gray-500">
                <span>
                    Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} Products
                </span>

                {{-- Sort Dropdown --}}
                <form method="GET">
                    <select name="sort" onchange="this.form.submit()" class="text-sm border border-gray-300 px-3 py-1.5 rounded-md bg-white">
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Grid Produk --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                @include('categories._product-card', ['product' => $product])
            @empty
                <p class="col-span-full text-gray-500">No products found.</p>
            @endforelse
        </div>

        {{-- Pagination Custom --}}
        <div class="mt-12 mb-20 flex justify-center">
            {{ $products->links('vendor.pagination.shopco') }}
        </div>
    </section>
</div>
@endsection
