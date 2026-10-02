<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse ($products as $product)
        <div class="border rounded-xl shadow p-4 bg-white">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md mb-3">
            <h3 class="font-semibold text-lg mb-1">{{ $product->name }}</h3>
            <div class="text-yellow-500 text-sm mb-1">
                ★★★☆☆ {{ $product->rating ?? '3' }}/5
            </div>
            <div class="font-bold text-lg">${{ number_format($product->price, 2) }}</div>
        </div>
    @empty
        <p>No products found.</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>



