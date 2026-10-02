@extends('layouts.seller')

@section('content')
    <main class="flex-1 p-6 bg-white overflow-y-auto">
        <h1 class="text-2xl font-bold mb-6">Katalog</h1>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Products</h2>
            <div class="flex items-center space-x-2">
                <input type="text" placeholder="Search product" class="border rounded px-3 py-1 text-sm focus:outline-none focus:ring focus:border-blue-300">
                <button class="p-2 rounded hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-data="{
            selectAll: false,
            confirmDelete: false,
            itemToDelete: null,
            itemToDeleteName: '',
            showEditModal: false,
            editingProduct: {
                id: null,
                name: '',
                description: '',
                price: '',
                stock: '',
                original_price: '',
                discount_type: '',
                discount_value: '',
                style: '', // Tambahkan ini agar bisa diedit di modal
                type: '', // Tambahkan ini agar bisa diedit di modal
            },

            openEdit(product) {
                this.editingProduct = { ...product };
                this.showEditModal = true;
            },
            calculateDiscountedPrice() {
                const p = this.editingProduct;
                if (p.original_price === null || p.original_price === '') {
                    p.price = '';
                    return;
                }

                let discountedPrice = parseFloat(p.original_price);

                if (p.discount_type === 'percent' && p.discount_value !== null && p.discount_value !== '') {
                    discountedPrice = discountedPrice * (1 - (parseFloat(p.discount_value) / 100));
                } else if (p.discount_type === 'fixed' && p.discount_value !== null && p.discount_value !== '') {
                    discountedPrice = discountedPrice - parseFloat(p.discount_value);
                }
                p.price = Math.max(0, discountedPrice).toFixed(2);
            }
        }" class="overflow-x-auto rounded-lg border border-gray-200 relative">

            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-3">
                            <input type="checkbox" x-model="selectAll"
                                @change="$el.closest('table').querySelectorAll('tbody input[type=checkbox]').forEach(cb => cb.checked = selectAll)">
                        </th>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Rating</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Sales</th>
                        <th class="px-4 py-3">Views</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($katalogs as $katalog)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <input type="checkbox" class="row-checkbox" />
                            </td>
                            <td class="px-4 py-4 flex items-center space-x-4">
                                <img src="{{ asset($katalog->image) }}" alt="{{ $katalog->name }}"
                                    class="w-12 h-12 rounded object-cover">
                                <div>
                                    <div class="font-semibold">{{ $katalog->name }}</div>

                                    {{-- Menampilkan Style produk --}}
                                    <div class="text-gray-500 text-xs">{{ $katalog->style ?? 'N/A Style' }}</div>

                                    {{-- Menampilkan deskripsi produk --}}
                                    @if ($katalog->description)
                                        <div class="text-gray-600 text-xs mt-1">
                                            Description: {{ \Illuminate\Support\Str::limit($katalog->description, 50) }}
                                        </div>
                                    @endif

                                    {{-- Menampilkan created_at produk --}}
                                    <div class="text-gray-600 text-xs">
                                        Created: {{ $katalog->created_at->format('Y-m-d H:i') }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 font-semibold">${{ number_format($katalog->price, 2) }}</td>
                            <td class="px-4 py-4 text-yellow-500">
                                <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                    @php
                                        // Pastikan method averageRating() ada di model Product (Katalog) Anda
                                        $rating = (int) round($katalog->averageRating() ?? 0);
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $rating ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    @endfor
                                    <span class="text-gray-500 ml-1">{{ $rating }}/5</span>
                                    {{-- Tampilkan jumlah ulasan jika tersedia --}}
                                    @if (method_exists($katalog, 'reviewsCount'))
                                        <span class="text-gray-400">({{ $katalog->reviewsCount() }})</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Active</span>
                            </td>
                            <td class="px-4 py-4">{{ $katalog->sales ?? '1,368' }}</td>
                            <td class="px-4 py-4">{{ $katalog->views ?? '1,368' }}</td>
                            <td class="px-4 py-4 space-x-2">
                                <button class="text-gray-500 hover:text-blue-600"
                                    @click="openEdit({
                                        id: {{ $katalog->id }},
                                        name: '{{ $katalog->name }}',
                                        description: `{{ $katalog->description ?? '' }}`,
                                        price: '{{ $katalog->price }}',
                                        stock: '{{ $katalog->stock ?? 0 }}',
                                        original_price: '{{ $katalog->original_price ?? $katalog->price }}',
                                        discount_type: '{{ $katalog->discount_type ?? '' }}',
                                        discount_value: '{{ $katalog->discount_value ?? '' }}',
                                        style: '{{ $katalog->style ?? '' }}', // Tambahkan style ke data edit
                                        type: '{{ $katalog->type ?? '' }}',   // Tambahkan type ke data edit
                                    })">
                                    Edit
                                </button>

                                <button class="text-gray-500 hover:text-red-600"
                                    @click="confirmDelete = true; itemToDelete = {{ $katalog->id }}; itemToDeleteName = '{{ $katalog->name }}'">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">No products found.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            <div x-show="confirmDelete" x-transition
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                style="display: none;">
                <div class="bg-white w-full max-w-md mx-auto p-6 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                    <p class="mb-4 text-sm text-gray-600">Are you sure you want to delete <span
                            class="font-medium text-gray-800" x-text="itemToDeleteName"></span>?</p>
                    <div class="flex justify-end space-x-3">
                        <button @click="confirmDelete = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancel
                        </button>
                        <form method="POST" :action="'/products/' + itemToDelete" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Yes, Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="showEditModal" x-transition
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                style="display: none;">
                <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-xl">
                    <h2 class="text-lg font-semibold mb-4">Edit Product</h2>
                    <form method="POST" :action="'/products/' + editingProduct.id">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div> <label class="block text-sm font-medium">Name</label>
                                <input type="text" x-model="editingProduct.name" name="name"
                                    class="w-full mt-1 border rounded px-3 py-2">
                            </div>
                            <div> <label class="block text-sm font-medium">Description</label>
                                <textarea x-model="editingProduct.description" name="description" class="w-full mt-1 border rounded px-3 py-2"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Original Price</label>
                                    <input type="number" x-model.number="editingProduct.original_price"
                                        name="original_price" step="0.01"
                                        class="w-full mt-1 border rounded px-3 py-2"
                                        @input="calculateDiscountedPrice">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Price (after discount)</label>
                                    <input type="number" x-model.number="editingProduct.price" name="price"
                                        step="0.01" class="w-full mt-1 border rounded px-3 py-2">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Discount Type</label>
                                    <select x-model="editingProduct.discount_type" name="discount_type"
                                        class="w-full mt-1 border rounded px-3 py-2"
                                        @change="calculateDiscountedPrice">
                                        <option value="">None</option>
                                        <option value="percent">Percent</option>
                                        <option value="fixed">Fixed Amount</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Discount Value</label>
                                    <input type="number" x-model.number="editingProduct.discount_value"
                                        name="discount_value" step="0.01"
                                        class="w-full mt-1 border rounded px-3 py-2"
                                        @input="calculateDiscountedPrice">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Style</label>
                                <input type="text" x-model="editingProduct.style" name="style"
                                    class="w-full mt-1 border rounded px-3 py-2">
                            </div>
                             <div>
                                <label class="block text-sm font-medium">Type</label>
                                <input type="text" x-model="editingProduct.type" name="type"
                                    class="w-full mt-1 border rounded px-3 py-2">
                            </div>

                            <div> <label class="block text-sm font-medium">Stock</label>
                                <input type="number" x-model="editingProduct.stock" name="stock"
                                    class="w-full mt-1 border rounded px-3 py-2">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showEditModal = false"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection