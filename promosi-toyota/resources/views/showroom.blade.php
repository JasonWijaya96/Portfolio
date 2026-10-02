@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-8">All Models</h1>

    <div class="mb-6">
        <a href="{{ route('showroom.create') }}"
           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
           + Tambah Mobil
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($showrooms->isEmpty())
        <p class="text-center text-gray-500">Belum ada mobil di showroom.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($showrooms as $car)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                    @if($car->image)
                        <img src="{{ Str::startsWith($car->image, 'showroom_images/') ? asset('storage/' . $car->image) : asset('images/' . $car->image) }}"
                             alt="{{ $car->title }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="bg-gray-200 w-full h-48 flex items-center justify-center text-gray-500 text-lg">
                            No Image
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800">{{ $car->title }}</h3>
                        @if($car->price)
                            <p class="text-gray-600 text-sm mt-1">
                                Rp {{ number_format($car->price, 0, ',', '.') }}
                            </p>
                        @endif
                        <p class="text-gray-700 mt-2 line-clamp-3">
                            {{ $car->description }}
                        </p>

                        <div class="flex items-center justify-between mt-4 space-x-2">
                            <a href="{{ route('showroom.show', $car->id) }}"
                               class="bg-blue-400 text-white px-3 py-1 rounded text-sm hover:bg-blue-500 transition">
                               Specs
                            </a>
                            <a href="{{ route('showroom.edit', $car->id) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">
                               Edit
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
