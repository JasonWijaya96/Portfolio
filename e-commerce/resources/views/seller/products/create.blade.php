@extends('layouts.seller')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Product Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-neutral-100">
  <div class="max-w-screen-xl mx-auto px-6 py-10">
    <!-- Header -->
    <div class="flex items-center gap-4">
      <h1 class="text-3xl font-semibold text-zinc-800">Product</h1>
    </div>

    <form id="productForm" action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-10" x-data="productPreview()" x-init="init">
    @csrf
      <!-- Form Section -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Name & Description -->
        <section class="bg-white p-6 rounded-2xl">
          <h2 class="text-xl font-semibold text-zinc-800 mb-6">Name & description</h2>
          <div class="space-y-4">
            <div>
              <label for="product-title" class="text-sm font-semibold text-zinc-800 flex items-center gap-1">
                Product title
          
              </label>
              <input type="text" id="product-title" name="name" placeholder="Input your text"
                     class="w-full mt-2 border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium text-zinc-800" />
              <p class="text-xs text-zinc-500 mt-1">Maximum 100 characters. No emoji allowed</p>
            </div>
            <div>
              <label for="description" class="text-sm font-semibold text-zinc-800 flex items-center gap-1">
                Description
          
              </label>
              <textarea id="description" name="description" placeholder="Write something..."
                        class="w-full mt-2 min-h-[120px] border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium text-zinc-800 bg-white resize-none"></textarea>
            </div>
          </div>
        </section>

        <!-- Images & Category -->
        <section class="bg-white p-6 rounded-2xl">
          <h2 class="text-xl font-semibold text-zinc-800 mb-6">Images & Category</h2>
          <div class="space-y-6">
            <div 
  x-data="{
    preview: null,
    handleDrop(e) {
      const file = e.dataTransfer.files[0];
      this.$refs.input.files = e.dataTransfer.files;
      this.showPreview(file);
    },
    handleChange() {
      const file = this.$refs.input.files[0];
      this.showPreview(file);
    },
    showPreview(file) {
  const reader = new FileReader();
  reader.onload = (e) => {
    this.preview = e.target.result;
    this.imagePreview = e.target.result; // ✅ Tambahkan baris ini
  };
  reader.readAsDataURL(file);
}
  }"
  x-on:drop.prevent="handleDrop"
  x-on:dragover.prevent
  x-on:click="$refs.input.click()"
  class="mt-2 h-48 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center text-gray-500 cursor-pointer relative overflow-hidden"
>
  <template x-if="preview">
    <img :src="preview" class="absolute inset-0 w-full h-full object-cover" />
  </template>
  <span x-show="!preview">Click or drop image</span>
  <input type="file" name="image" accept="image/*" x-ref="input" class="hidden" @change="handleChange">
</div>

            <div>
              <label class="text-sm font-semibold text-zinc-800 flex items-center gap-1">
                Category
          
              </label>
              <select name="category_id" id="category"
        class="mt-2 w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-zinc-800">
  @foreach($categories as $category)
    <option value="{{ $category->id }}">{{ $category->type }}</option>
  @endforeach
</select>
            </div>
            <div>
  <label class="text-sm font-semibold text-zinc-800 flex items-center gap-1">
    Dress Style
  </label>
  <select name="style" id="style"
    class="mt-2 w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-zinc-800">
    @foreach($categories as $category)
      <option value="{{ $category->name }}">{{ $category->name }}</option>
    @endforeach
  </select>
</div>

<!-- Brand Dropdown -->
<div>
  <label for="brand" class="text-sm font-semibold text-zinc-800 flex items-center gap-1">
    Brand
  </label>
  <select name="brand_id" id="brand" class="mt-2 w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-zinc-800">
    <option value="" disabled selected>Select a brand</option>
    @foreach($brands as $brand)
      <option value="{{ $brand->id }}">{{ $brand->name }}</option>
    @endforeach
  </select>
</div>


          </div>
        </section>

        <!-- Price -->
<section class="bg-white p-6 rounded-2xl">
  <h2 class="text-xl font-semibold text-zinc-800 mb-6">Price</h2>
  <div>
    <label class="text-sm font-semibold text-zinc-800 flex items-center gap-1">
      Amount
    </label>
    <div class="mt-2 flex items-center border border-gray-300 rounded-xl overflow-hidden">
      <span class="bg-gray-100 px-4 py-2 text-zinc-600 font-medium">$</span>
      <input type="number" name="price" value="0" class="w-full px-4 py-2 outline-none border-none text-zinc-800" />
    </div>
  </div>

  <!-- Tambahan: Discount -->
  <div class="mt-6">
    <label class="text-sm font-semibold text-zinc-800 flex items-center gap-1">
      Discount (%)
    </label>
    <input type="number" name="discount" min="0" max="100" value="0" class="mt-2 w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium text-zinc-800" />
    <p class="text-xs text-zinc-500 mt-1">Optional. Set 0 if no discount.</p>
  </div>

  <!-- Tambahan: Stock -->
  <div class="mt-6">
    <label class="text-sm font-semibold text-zinc-800 flex items-center gap-1">
      Stock
    </label>
    <input type="number" name="stock" min="1" value="1" class="mt-2 w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium text-zinc-800" />
    <p class="text-xs text-zinc-500 mt-1">Minimum 1</p>
  </div>

  <!-- Size Selection -->
<div class="mt-6">
  <label class="text-sm font-semibold text-zinc-800 flex items-center gap-1 mb-2">
    Available Sizes
  </label>
  <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
    <template x-for="size in ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL']" :key="size">
      <button
        type="button"
        class="px-4 py-2 rounded-xl border text-sm font-medium"
        :class="sizes.includes(size) ? 'bg-gray-800 text-white' : 'bg-white text-zinc-800 border-gray-300 hover:bg-zinc-100'"
        @click="
  if (sizes.includes(size)) {
    sizes = sizes.filter(s => s !== size)
  } else {
    sizes.push(size)
    const order = ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL']
    sizes = sizes.sort((a, b) => order.indexOf(a) - order.indexOf(b))
  }
"
        x-text="size"
      ></button>
    </template>
  </div>
  <!-- Hidden input to submit selected sizes -->
  <input type="hidden" name="sizes" :value="sizes.join(',')" />
</div>

<!-- Color Dropdown -->
<div class="mt-6">
  <label for="color" class="text-sm font-semibold text-zinc-800 flex items-center gap-1 mb-2">
    Color
  </label>
  <select name="color" id="color"
    class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white text-zinc-800">
    <option value="" disabled selected>Select a color</option>
    <option value="green">Green</option>
    <option value="red">Red</option>
    <option value="yellow">Yellow</option>
    <option value="orange">Orange</option>
    <option value="cyan">Cyan</option>
    <option value="blue">Blue</option>
    <option value="purple">Purple</option>
    <option value="pink">Pink</option>
    <option value="white">White</option>
    <option value="black">Black</option>
  </select>
</div>

</section>
      </div>

      <aside class="bg-white p-4 rounded-2xl shadow-sm max-w-xs">
  <div class="space-y-3">
    <!-- Judul Preview -->
    <div class="flex items-center justify-between">
      <p class="text-base font-semibold text-zinc-800">Preview</p>
    </div>

    <!-- Gambar Produk -->
    <div class="rounded-xl overflow-hidden aspect-[4/5]">
      <template x-if="imagePreview">
        <img :src="imagePreview" class="w-full h-full object-cover" />
      </template>
      <div x-show="!imagePreview"
           class="w-full h-full bg-gray-100 flex items-center justify-center text-zinc-400 text-sm">Image preview</div>
    </div>

    <!-- Nama Produk -->
<p class="font-semibold text-zinc-800 text-base leading-tight" x-text="name || 'Product name'"></p>

<!-- Deskripsi -->
<p class="text-sm text-zinc-600" x-text="description || 'Product description'"></p>

<!-- Kategori & Style -->
<div class="text-sm text-zinc-500">
  <span x-show="category">Category: <span class="font-semibold text-zinc-700" x-text="category"></span></span><br>
  <span x-show="style">Dress Style: <span class="font-semibold text-zinc-700" x-text="style"></span></span><br>
  <span x-show="brand">Brand: <span class="font-semibold text-zinc-700" x-text="brand"></span></span>
</div>

<!-- Harga -->
    <div class="flex items-center gap-2 mt-2">
      <span class="text-lg font-bold text-zinc-800" x-text="`$${priceAfterDiscount}`"></span>
      <span class="text-sm text-zinc-500 line-through" x-text="discount > 0 ? `$${originalPrice}` : ''"></span>
      <span class="text-sm font-semibold text-pink-700 bg-pink-100 px-2 py-0.5 rounded-full"
            x-show="discount > 0" x-text="`-${discount}%`"></span>
    </div>

<!-- Stock -->
<p class="text-sm mt-1 text-zinc-500" x-show="stock">
  Stock: <span class="font-semibold text-zinc-700" x-text="stock"></span>
</p>

<!-- Sizes -->
<p class="text-sm mt-1 text-zinc-500" x-show="sizes.length > 0">
  Sizes: <span class="font-semibold text-zinc-700" x-text="sizes.join(', ')"></span>
</p>

<!-- Color -->
<p class="text-sm mt-1 text-zinc-500" x-show="color">
  Color: <span class="font-semibold text-zinc-700" x-text="color.charAt(0).toUpperCase() + color.slice(1)"></span>
</p>

  </div>
</aside>
    </form>

    <!-- Footer Buttons -->
    <div class="mt-10 flex justify-between items-center flex-wrap gap-4">
      <p class="text-sm text-zinc-500">
      </p>
      <div class="flex gap-3">
        <button 
  type="submit"
  id="publishButton"
  class="px-6 py-3 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700">
  Publish now
</button>
      </div>
    </div>
  </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('productForm');
    const publishBtn = document.getElementById('publishButton');

    publishBtn.addEventListener('click', function (e) {
        e.preventDefault(); // cegah submit langsung

        const name = form.querySelector('input[name="name"]');
        const price = form.querySelector('input[name="price"]');
        const category = form.querySelector('select[name="category_id"]');
        const image = form.querySelector('input[name="image"]');
        const sizes = form.querySelector('input[name="sizes"]');
        const color = form.querySelector('select[name="color"]');
        const brand = form.querySelector('select[name="brand_id"]');

        let valid = true;
        let messages = [];

        if (!name.value.trim()) {
            valid = false;
            messages.push("Product name is required.");
        }

        if (!brand.value) {
            valid = false;
            messages.push("Please select a brand.");
        }

        if (!price.value.trim() || parseFloat(price.value) <= 0) {
    valid = false;
    messages.push("Price must be greater than 0.");
}

        if (image.files.length === 0) {
            valid = false;
            messages.push("Please upload an image.");
        }

        if (!sizes.value.trim()) {
    valid = false;
    messages.push("Please select at least one size.");
}

if (!color.value) {
    valid = false;
    messages.push("Please select a color.");
}

        if (!valid) {
            alert(messages.join('\n'));
            return;
        }

        // Jika valid, submit form
        form.submit();
    });
});

function productPreview() {
  return {
    name: '',
    description: '',
    price: 0,
    originalPrice: 0,
    discount: 0,
    stock: 1,
    imagePreview: null,
    category: '',
    style: '',
    sizes: [],
    color: '',
    brand: '',
    get priceAfterDiscount() {
      if (this.discount > 0) {
        return (this.originalPrice * (1 - this.discount / 100)).toFixed(2);
      }
      return parseFloat(this.originalPrice).toFixed(2);
    },
    init() {
  const nameInput = document.querySelector('input[name="name"]');
  const descriptionInput = document.querySelector('textarea[name="description"]');
  const priceInput = document.querySelector('input[name="price"]');
  const discountInput = document.querySelector('input[name="discount"]');
  const stockInput = document.querySelector('input[name="stock"]');
  const imageInput = document.querySelector('input[name="image"]');
  const categoryInput = document.querySelector('select[name="category_id"]');
  const styleInput = document.querySelector('select[name="style"]');
  const colorInput = document.querySelector('select[name="color"]');
  const brandInput = document.querySelector('select[name="brand_id"]');

  // 👇 Initial values (fix your issue)
  this.name = nameInput.value;
  this.description = descriptionInput.value;
  this.originalPrice = parseFloat(priceInput.value) || 0;
  this.discount = parseFloat(discountInput.value) || 0;
  this.stock = parseInt(stockInput.value) || 1;
  this.category = categoryInput.options[categoryInput.selectedIndex]?.text || '';
  this.style = styleInput.options[styleInput.selectedIndex]?.text || '';
  this.color = colorInput.value;
  this.brand = brandInput.options[brandInput.selectedIndex]?.text || '';

  nameInput.addEventListener('input', () => {
    this.name = nameInput.value;
  });
  descriptionInput.addEventListener('input', () => {
    this.description = descriptionInput.value;
  });
  priceInput.addEventListener('input', () => {
    this.originalPrice = parseFloat(priceInput.value) || 0;
  });
  discountInput.addEventListener('input', () => {
    this.discount = parseFloat(discountInput.value) || 0;
  });
  stockInput.addEventListener('input', () => {
  this.stock = parseInt(stockInput.value) || 1;
});
  categoryInput.addEventListener('change', () => {
    this.category = categoryInput.options[categoryInput.selectedIndex]?.text || '';
  });
  styleInput.addEventListener('change', () => {
    this.style = styleInput.options[styleInput.selectedIndex]?.text || '';
  });
  colorInput.addEventListener('change', () => {
    this.color = colorInput.value;
  });
  brandInput.addEventListener('change', () => {
                this.brand = brandInput.options[brandInput.selectedIndex]?.text || '';
            });
  imageInput.addEventListener('change', () => {
    const file = imageInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => this.imagePreview = e.target.result;
      reader.readAsDataURL(file);
    }
  });

}

  }
}

</script>

@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.createElement('div');
    modal.innerHTML = `
      <div class="fixed inset-0 bg-black/30 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg max-w-sm w-full p-6 text-center space-y-4 animate-scale">
          <h2 class="text-xl font-semibold text-green-600">Success!</h2>
          <p class="text-sm text-zinc-700">{{ session('success') }}</p>
          <button class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" onclick="this.closest('.fixed').remove()">Close</button>
        </div>
      </div>
    `;
    document.body.appendChild(modal);
  });
</script>
@endif

<style>
  @keyframes scale {
    0% { transform: scale(0.95); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
  }
  .animate-scale {
    animation: scale 0.2s ease-out;
  }
</style>

</body>
</html>
@endsection