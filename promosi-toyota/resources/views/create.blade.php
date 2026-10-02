@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center text-red-600">Tambah Mobil</h2>

    <form action="{{ route('showroom.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
        <label class="block font-semibold mb-1">Model Name</label>
        <input type="text" name="title" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full border p-2 rounded" required></textarea>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Specs</label>
        <textarea name="specs" rows="4" class="w-full border p-2 rounded"></textarea>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Harga (Rp)</label>
        <input type="number" name="price" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
    <label class="inline-flex items-center">
        <input type="checkbox" name="featured" class="form-checkbox text-red-600">
        <span class="ml-2">Jadikan Featured Model</span>
    </label>
</div>

    <div class="mb-6">
        <label class="block font-semibold mb-1">Gambar Mobil</label>
        <input type="file" name="image" class="w-full" required>
    </div>

        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Simpan
        </button>
        
        <a href="{{ route('showroom.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Back
        </a>
    </form>

</div>
@endsection
