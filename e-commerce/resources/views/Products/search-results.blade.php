@extends('layouts.default')

@section('title', 'Search Results')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <h2 class="text-2xl font-bold mb-6">
        Search Results for "{{ $keyword }}"
    </h2>

    @if($products->count())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('categories._product-card', ['product' => $product])
            @endforeach
            
        </div>

        <div class="mt-12 flex justify-center">
            {{ $products->links('vendor.pagination.shopco') }}
        </div>
    @else
        <p class="text-gray-500">No products found matching "{{ $keyword }}".</p>
    @endif

</div>
@endsection
