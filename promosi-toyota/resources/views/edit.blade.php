@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-4">Edit Mobil</h1>

    <form action="{{ route('showroom.update', $showroom->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Model Name</label>
            <input type="text" name="title"
                   class="w-full border p-2 rounded"
                   value="{{ old('title', $showroom->title) }}"
                   required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" rows="4"
                      class="w-full border p-2 rounded">{{ old('description', $showroom->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Spesifikasi Lengkap</label>
            <textarea name="specs" rows="4"
                      class="w-full border p-2 rounded">{{ old('specs', $showroom->specs) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Harga (Rp)</label>
            <input type="number" name="price"
       class="w-full border p-2 rounded"
       value="{{ old('price', $showroom->price) }}"
       max="2147483647">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Gambar Mobil</label>
            <input type="file" name="image">
            @if($showroom->image)
                <p class="text-sm text-gray-500 mt-1">Gambar sekarang: {{ $showroom->image }}</p>
            @endif
        </div>

        <button type="submit"
                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 mr-4">
            Update
        </button>

        <a href="{{ route('showroom.index') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
           Back
        </a>
    </form>
</div>
@endsection
