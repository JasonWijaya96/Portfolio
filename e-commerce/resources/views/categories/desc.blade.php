@extends('layouts.default')

@section('content')

@php
    $rating = (int) round($product->averageRating() ?? 0);
@endphp

<div class="max-w-6xl mx-auto py-10 px-4 mb-20">

            <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="list-reset flex">
            <li>
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <span class="mx-2">></span>
            </li>
                <li>
                <a href="{{ route('categories.index') }}" class="hover:underline">Products</a>
                <span class="mx-2">></span>
            </li>
            <li class="text-black font-semibold">
                New Arrivals {{-- Diubah dari "brand" menjadi "Brands" agar lebih baik --}}
            </li>
        </ol>
    </nav>
    {{-- Product Details Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8" x-data="productDetail()">
        {{-- Product Image --}}
        <div>
            <div class="border rounded-xl overflow-hidden w-full" style="aspect-ratio: 1 / 1;">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
            </div>
        </div>

        {{-- Product Info --}}
        <div class="flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ strtoupper($product->name) }}</h1>

                {{-- Star Rating --}}
                <div class="flex items-center mt-2 space-x-1 text-yellow-400 text-sm">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="{{ $i <= $rating ? 'currentColor' : 'none' }}"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    @endfor
                    <span class="text-gray-600 ml-1">{{ $rating }}/5</span>
                </div>

                {{-- Price --}}
                <div class="flex items-center mt-4 space-x-3">
                    <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @if ($product->original_price && $product->original_price > $product->price)
                        <span class="text-gray-500 line-through">${{ number_format($product->original_price, 2) }}</span>
                        <span class="text-pink-600 text-sm font-semibold bg-pink-100 px-2 py-1 rounded-full">
                            -{{ 100 - round(($product->price / $product->original_price) * 100) }}%
                        </span>
                    @endif
                </div>

                {{-- Description --}}
                <p class="mt-4 text-gray-600">{{ $product->description }}</p>

                {{-- Color --}}
                <div class="mt-4">
                    <span class="text-sm text-gray-600">Color: </span>
                    <div class="flex space-x-2 mt-1">
                        <div class="w-6 h-6 rounded-full border-2 {{ $product->color === 'blue' ? 'border-black' : 'border-gray-300' }}" style="background-color: {{ $product->color ?? '#FFFFFF' }}"></div>
                    </div>
                </div>

                {{-- Stock --}}
                <div class="mt-2 text-gray-600 text-sm">
                    Stock: <span class="font-semibold">{{ $product->stock ?? 0 }}</span>
                    @if ($product->stock && $product->stock < 10 && $product->stock > 0)
                        <span class="text-red-500 ml-2">(Low Stock!)</span>
                    @elseif (!$product->stock || $product->stock === 0)
                        <span class="text-red-500 ml-2">(Out of Stock)</span>
                    @endif
                </div>

                {{-- Size & Quantity --}}
                <div x-data="{ selectedSize: null, quantity: 1, stock: {{ $product->stock ?? 0 }} }" class="mt-6">
                    {{-- Size Selection --}}
                    <div>
                        <span class="text-sm text-gray-600">Size:</span>
                        <div class="flex space-x-2 mt-1">
                            @foreach ($sizes as $size)
                                <button
                                    type="button"
                                    @click="selectedSize = '{{ $size }}'"
                                    :class="selectedSize === '{{ $size }}' ? 'bg-black text-white' : 'border border-gray-300 text-gray-700'"
                                    class="px-4 py-2 rounded-full text-sm font-semibold hover:border-black transition">
                                    {{ strtoupper($size) }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Add to Cart Form --}}
                    <form action="{{ route('cart.add') }}" method="POST" @submit.prevent="
                        if (!selectedSize) { alert('Please select a size first!'); return; }
                        if (quantity > stock) { alert('Quantity exceeds available stock (' + stock + ').'); return; }
                        $el.submit();
                    " class="mt-6 flex items-center space-x-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="size" :value="selectedSize" />
                        <input type="hidden" name="quantity" :value="quantity" />

                        <div class="flex items-center border border-gray-300 rounded-full px-3 py-1">
                            <button type="button" class="text-gray-500 hover:text-black px-3 select-none" @click="quantity > 1 ? quantity-- : null">-</button>
                            <span class="px-4 select-none" x-text="quantity"></span>
                            <button type="button" class="text-gray-500 hover:text-black px-3 select-none" @click="quantity < stock ? quantity++ : null" :disabled="quantity >= stock">+</button>
                        </div>

                        <button type="submit" class="bg-black text-white px-6 py-2 rounded-full hover:opacity-90 transition disabled:opacity-50" :disabled="quantity === 0 || quantity > stock || !selectedSize">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Section --}}
    <div class="mt-12 max-w-4xl mx-auto">
        <div class="max-w-screen-lg mx-auto">
            <div class="flex justify-center gap-x-4 sm:gap-x-40 border-b border-gray-300 mb-6">
                <button onclick="showTab('details', this)" class="tab-btn py-2 text-gray-500 hover:text-black">Product Details</button>
                <button onclick="showTab('reviews', this)" class="tab-btn py-2 text-gray-500 hover:text-black">Rating & Reviews</button>
                <button onclick="showTab('faq', this)" class="tab-btn py-2 text-gray-500 hover:text-black">FAQ's</button>
            </div>
        </div>

        {{-- Product Details Tab --}}
        <div id="tab-details" class="tab-content hidden">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Product Description</h2>
            <p class="text-gray-700">{{ $product->description }}</p>
        </div>

        {{-- Rating & Reviews Tab --}}
        <div id="tab-reviews" class="tab-content hidden">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">All Reviews</h3>
                <div class="flex items-center space-x-2">
                    <select id="ajax-filter" class="border rounded px-3 py-1 text-sm text-gray-700">
                        <option value="latest">Latest</option>
                        <option value="oldest">Oldest</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>

                    <div x-data="{ open: false, selectedRating: 0 }" class="relative z-10">
                        @auth
                            <button @click="open = true" class="bg-black text-white text-sm px-4 py-2 rounded hover:opacity-90">Write a Review</button>
                            <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
                                <div @click.away="open = false" class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                                    <h2 class="text-lg font-semibold mb-4">Write a Review</h2>
                                    <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                            <div class="flex space-x-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <label @click="selectedRating = {{ $i }}">
                                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden" required :checked="selectedRating === {{ $i }}">
                                                        <svg class="w-6 h-6 cursor-pointer fill-current" :class="selectedRating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" /></svg>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Review</label>
                                            <textarea name="content" rows="4" required class="w-full border rounded p-2"></textarea>
                                        </div>
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" @click="open = false" class="text-gray-600">Cancel</button>
                                            <button type="submit" class="bg-black text-white px-4 py-2 rounded">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="bg-black text-white text-sm px-4 py-2 rounded hover:opacity-90">Login to Write a Review</a>
                        @endauth
                    </div>
                </div>
            </div>
            <div id="review-section" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('categories._comments', ['comments' => $comments])
            </div>
        </div>

        {{-- FAQ Tab --}}
        <div id="tab-faq" class="tab-content hidden">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Frequently Asked Questions</h2>
            <ul class="space-y-3 text-gray-700">
                <li><strong>Q:</strong> How long is the delivery time?<br><strong>A:</strong> Delivery usually takes 3–5 business days.</li>
                <li><strong>Q:</strong> Is there a warranty?<br><strong>A:</strong> Yes, this product includes a 1-year warranty.</li>
            </ul>
        </div>
    </div>
</div>

<div class="h-10"></div>

{{-- Scripts --}}
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function productDetail() {
        return {};
    }

    function showTab(tabId, clickedButton) {
        document.querySelectorAll('.tab-content').forEach(tabContent => tabContent.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.classList.remove('text-gray-700', 'font-semibold', 'border-b-2', 'border-black');
            button.classList.add('text-gray-500', 'hover:text-black');
        });
        document.getElementById('tab-' + tabId).classList.remove('hidden');
        clickedButton.classList.add('text-gray-700', 'font-semibold', 'border-b-2', 'border-black');
        clickedButton.classList.remove('text-gray-500');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Activate the first tab by default
        const firstTabButton = document.querySelector('.tab-btn');
        if (firstTabButton) {
            showTab('details', firstTabButton);
        }
        
        // AJAX for review filtering
        const filterSelect = document.getElementById('ajax-filter');
        const reviewSection = document.getElementById('review-section');
        if (filterSelect) {
            filterSelect.addEventListener('change', function () {
                const filter = this.value;
                const productId = {{ $product->id }};
                fetch(`/products/${productId}/comments?filter=${filter}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => reviewSection.innerHTML = html)
                    .catch(error => console.error('Error loading comments:', error));
            });
        }
    });
</script>

@endsection