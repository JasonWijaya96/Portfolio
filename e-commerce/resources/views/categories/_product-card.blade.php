@props(['product', 'from' => null])

<a href="{{ route('products.show', $product->slug) }}{{ $from ? '?from=' . $from : '' }}" class="block">
    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
        {{-- Gambar --}}
        <div class="w-full h-52 bg-gray-100 flex items-center justify-center overflow-hidden">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="object-contain h-full">
        </div>

        {{-- Detail --}}
        <div class="p-4 space-y-1">
            {{-- Nama --}}
            <h3 class="text-sm font-semibold text-gray-800 line-clamp-2">
                {{ $product->name }}
            </h3>

            {{-- Rating --}}    
            <div class="flex items-center gap-1 text-yellow-400 text-xs">
                @php
                    $rating = (int) round($product->averageRating() ?? 0);
                @endphp
                @for($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $rating ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
                    </svg>
                @endfor
                <span class="text-gray-500 ml-1">{{ $rating }}/5</span>
            </div>

            {{-- Harga --}}
            <div class="flex items-center gap-2">
                <span class="text-base font-semibold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @if ($product->original_price && $product->original_price > $product->price)
                    <span class="line-through text-sm text-gray-400">${{ number_format($product->original_price, 2) }}</span>
                    <span class="text-xs bg-pink-100 text-pink-600 px-1.5 py-0.5 rounded-full font-medium">
                        -{{ 100 - round($product->price / $product->original_price * 100) }}%
                    </span>
                @endif
            </div>
        </div>
    </div>
</a>
