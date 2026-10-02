@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    @if($showroom->image)
    <img src="{{ Str::startsWith($showroom->image, 'showroom_images/') ? asset('storage/' . $showroom->image) : asset('images/' . $showroom->image) }}"
     alt="{{ $showroom->title }}"
     class="w-full h-auto object-cover rounded mb-4">
    @endif

    <h1 class="text-3xl font-bold mb-2">
        {{ $showroom->title }}
    </h1>
    @if($showroom->price)
        <p class="text-gray-600">
            Harga: Rp {{ number_format($showroom->price, 0, ',', '.') }}
        </p>
    @endif

    <p class="mt-4 text-gray-700">
        {{ $showroom->description }}
    </p>

    @if($showroom->specs)
        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-2">Specs</h2>
            {{-- Kita pakai whitespace-pre-line agar baris baru di DB terbaca di HTML --}}
            <p class="whitespace-pre-line text-gray-700">
                {{ $showroom->specs }}
            </p>
        </div>
    @endif

    <div class="mt-6 flex gap-4">
        <a href="{{ route('showroom.edit', $showroom->id) }}"
           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
           Edit
        </a>
        
        <form action="{{ route('showroom.destroy', $showroom->id) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus mobil ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Hapus
            </button>
        </form>
        
        <a href="{{ route('showroom.index') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
           Back
        </a>
    </div>
</div>
@endsection
