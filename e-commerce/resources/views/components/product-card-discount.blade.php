@props(['product'])

<a href="{{ route('products.show', $product->slug) }}" class="block h-full">
    <div class="relative bg-white border rounded-xl shadow p-3 hover:shadow-md transition duration-200 flex flex-col justify-between h-full">

        {{-- 🔴 Badge Diskon --}}
        @if($product->original_price > $product->price)
            <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">
                -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
            </span>
        @endif

        {{-- 📷 Gambar Produk --}}
        <div class="aspect-[4/3] w-full overflow-hidden rounded-md mb-2">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        </div>

        {{-- 🚨 Stok Info --}}
        @if($product->stock <= 5)
            <div class="text-xs text-red-600 font-medium mb-1">Segera Habis</div>
        @endif

        {{-- 📝 Nama --}}
        <h3 class="text-xs font-semibold text-gray-800 line-clamp-2 mb-1">
            {{ $product->name }}
        </h3>

        {{-- 💰 Harga --}}
        <div class="mb-1">
            <span class="text-sm font-bold text-red-600">${{ number_format($product->price, 2) }}</span>
            <span class="text-xs text-gray-400 line-through ml-1">${{ number_format($product->original_price, 2) }}</span>
        </div>

        {{-- 🏷️ Brand --}}
        <div class="text-[11px] text-gray-500">
            {{ $product->brand->name ?? 'PremiumStore' }}
        </div>
    </div>
</a>
