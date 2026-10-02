@extends('layouts.default')

@section('content')
{{-- Kontainer utama dengan padding atas dan bawah --}}
<div class="container mx-auto px-4 py-10">

    {{-- Breadcrumb dipindahkan ke bagian atas konten, sebelum judul utama. --}}
    {{-- Margin atas yang besar (mt-12) dihapus. --}}
    <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="list-reset flex">
            <li>
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <span class="mx-2">></span>
            </li>
            <li class="text-black font-semibold">
                Brands {{-- Diubah dari "brand" menjadi "Brands" agar lebih baik --}}
            </li>
        </ol>
    </nav>

    {{-- Judul utama halaman diletakkan setelah breadcrumb --}}
    <h2 class="text-2xl font-bold mb-6">🏷️ Browse by Brand</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($brands as $brand)
            <a href="{{ route('brands.show', $brand->slug) }}" class="block p-4 border rounded-lg shadow hover:bg-gray-50 transition">
                <h3 class="text-lg font-semibold">{{ $brand->name }}</h3>
                <p class="text-sm text-gray-500">{{ $brand->products()->count() }} products</p>
            </a>
        @endforeach
    </div>
</div>
@endsection