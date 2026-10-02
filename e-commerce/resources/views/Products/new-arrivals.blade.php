@extends('layouts.default')

@section('content')
<div class="container mx-auto px-4 py-10 ">

        <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="list-reset flex">
            <li>
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <span class="mx-2">></span>
            </li>
            <li class="text-black font-semibold">
                New Arrivals {{-- Diubah dari "brand" menjadi "Brands" agar lebih baik --}}
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl font-bold mb-6">✨ New Arrivals</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($products as $product)
            @include('categories._product-card', ['product' => $product])
        @endforeach
    </div>
</div>
@endsection
