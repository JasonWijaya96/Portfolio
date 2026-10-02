@extends('layouts.default')

@section('title' , 'Home Page')

@push('styles')
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <style>
        .font-nike {
            font-family: 'Bebas Neue', sans-serif;
        }
        .font-adidas {
            font-family: 'Orbitron', sans-serif;
        }
        .font-uniqlo {
            font-family: 'Noto Sans', sans-serif;
        }
        .font-zara {
            font-family: 'Playfair Display', serif;
        }
        .font-hm {
            font-family: 'Montserrat', sans-serif;
        }
        .font-size{
            font-size:xx-large;
        }
        .text-xl {
            font-size: 1.5rem /* 20px */;
            line-height: 2rem /* 28px */;
        }

        body {
      font-family: Arial, sans-serif;
      background-color: #f3f3f3;
      margin: 0;
        }

    h1 {
      font-size: 28px;
      font-weight: 800;
      margin-bottom: 30px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }

    .grid-item {
      position: relative;
      overflow: hidden;
      border-radius: 12px;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .grid-item:hover {
      transform: scale(1.03);
    }

    .grid-item img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      display: block;
    }

    .label {
      position: absolute;
      top: 15px;
      left: 15px;
      background: rgba(255, 255, 255, 0.85);
      padding: 8px 12px;
      font-weight: bold;
      border-radius: 6px;
      font-size: 16px;
    }
    </style>

@endpush
@section('content')

{{-- top page, buat display statistik dan gambar orangnya, tombol shop now bisa dipake nanti --}}
<section class="hero bg-[#f2f0f1] px-12 py-12 md:py-24 flex flex-col md:flex-row items-center justify-between overflow-hidden relative h-[600px]">
    <div class="hero-text max-w-xl text-center md:text-left z-10">
        <h2 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            FIND CLOTHES <br class="hidden md:block" /> THAT MATCHES YOUR STYLE
        </h2>
        <p class="text-gray-600 mb-6">
            Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.
        </p>
        <a href="{{ route('categories.index') }}" 
                class="bg-black text-white text-sm px-6 py-3 rounded-full mb-8 md:mb-12 hover:bg-gray-800 transition inline-block">
            Shop Now
        </a>


        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center md:text-left text-black">
            <div>
                <p class="text-2xl font-bold">200+</p>
                <p class="text-sm text-gray-500">International Brands</p>
            </div>
            <div>
                <p class="text-2xl font-bold">2,000+</p>
                <p class="text-sm text-gray-500">High-Quality Products</p>
            </div>
            <div>
                <p class="text-2xl font-bold">30,000+</p>
                <p class="text-sm text-gray-500">Happy Customers</p>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 right-0 md:static mt-12 md:mt-0 md:ml-12">
        {{-- img yang dipake aku download dari figma, udh ada di file "C:\laragon\www\WFD_E_COMMERCE_PROJECT\public\images\homepage pic.jpg" --}}
        <img src="{{ asset('butuh\homepage.jpg') }}" 
            alt="Model Fashion Desktop" 
            class="hidden md:block w-full max-w-[800px] object-cover translate-y-1/4"
        />
    </div>
</section>


</section>


<section class="brand-logos py-8 bg-black">
    <div class="mx-auto grid grid-cols-2 md:grid-cols-5 items-center justify-items-center gap-y-6 text-white text-xl font-semibold">
        @foreach ($brands as $brand)
            <a href="{{ route('brands.show', $brand->slug) }}"
               class="font-{{ strtolower($brand->name) }} transition duration-1000 ease-in-out text-white p-5 hover:text-black transform hover:-translate-y-1 hover:scale-110">
                {{ strtoupper($brand->name) }}
            </a>
        @endforeach
    </div>
</section>


        

{{-- newest arrivals, buat display item yang paling baru ditambahkan, sampai ke menit/detik --}}
<section class="new-arrivals text-center p-8">
  <h3 class="text-2xl font-bold mb-6">NEWEST ARRIVALS</h3>
  <div class="flex overflow-x-auto space-x-4 px-2 scrollbar-hide md:overflow-x-visible md:grid md:grid-cols-5 md:gap-6">
    @forelse ($released as $release)
      <div class="w-[220px] flex-shrink-0 md:w-auto">
       @include('categories._product-card', ['product' => $release, 'from' => 'new-arrivals'])
      </div>
    @empty
      <p>No products found.</p>
    @endforelse
  </div>
</section>


<section>
    <div class="view-all text-center">
        <a href="/new-arrivals"
            class="transition duration-1000 ease-in-out bg-gray-200 hover:bg-black text-black hover:text-white p-5 rounded-full inline-block">
            View All
        </a>
    </div>
</section>

<hr class="my-8 border-t border-gray-400 w-4/5 mx-auto">

{{-- top selling, buat display item dengan harga tertinggi --}}
<section class="new-arrivals text-center p-8">
  <h3 class="text-2xl font-bold mb-6">🔥 Top Selling</h3>
  <div class="flex overflow-x-auto space-x-4 px-2 scrollbar-hide md:overflow-x-visible md:grid md:grid-cols-5 md:gap-6">
    @forelse ($topselling as $topsells)
      <div class="w-[220px] flex-shrink-0 md:w-auto relative">
        {{-- 🔥 Badge Top --}}
        <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded-full shadow-md z-10">
          🔥 Top
        </span>

        @include('categories._product-card', ['product' => $topsells, 'from' => 'top-selling'])
      </div>
    @empty
      <p>No top selling products found.</p>
    @endforelse
  </div>
</section>



<section class="mb-12">
    <div class="view-all text-center">
        <a href="/top-selling"
            class="transition duration-1000 ease-in-out bg-gray-200 hover:bg-black text-black hover:text-white p-5 rounded-full inline-block">
            View All
        </a>
    </div>
</section>

{{-- browse by dress style, masih perlu href buat ngarah ke page style baju --}}
<section class="mx-12 py-10 bg-gray-200 rounded">
  <h1 class="text-center text-3xl font-bold mb-6">BROWSE BY DRESS STYLE</h1>
  <div class="grid grid-cols-3 gap-4 px-12">
    {{-- row 1 --}}
    <a href="/categories?style=Casual" class="col-span-2 bg-white rounded overflow-hidden shadow transition duration-1000 ease-in-out hover:bg-black text-black hover:text-white p-5 inline-block">
      <img src="butuh/casual.png" alt="Casual" class="w-full h-48 object-cover" />
      <div class="p-4 font-semibold text-lg">Casual</div>
    </a>
    <a href="/categories?style=Formal" class="bg-white rounded overflow-hidden shadow transition duration-1000 ease-in-out hover:bg-black text-black hover:text-white p-5 inline-block">
      <img src="butuh/formal.png" alt="Formal" class="w-full h-48 object-cover" />
      <div class="p-4 font-semibold text-lg">Formal</div>
    </a>

    {{-- row 2 --}}
    <a href="/categories?style=Party" class="bg-white rounded overflow-hidden shadow transition duration-1000 ease-in-out hover:bg-black text-black hover:text-white p-5 inline-block">
      <img src="butuh/party.png" alt="Party" class="w-full h-48 object-cover" />
      <div class="p-4 font-semibold text-lg">Party</div>
    </a>
    <a href="/categories?style=Gym" class="col-span-2 bg-white rounded overflow-hidden shadow transition duration-1000 ease-in-out hover:bg-black text-black hover:text-white p-5 inline-block">
      <img src="butuh/gym.png" alt="Gym" class="w-full h-48 object-cover" />
      <div class="p-4 font-semibold text-lg">Gym</div>
    </a>
  </div>
</section>


<script>
  function testimonialSlider() {
    return {
      current: 0,
      visible: 4,
      testimonials: [
        { name: 'Maya L.', quote: 'Stylish yet timeless—exactly what I needed in my wardrobe. I can easily dress the pieces up or down, and they always look chic. The durability is impressive; after many wears and washes, my clothes still look brand new.' },
        { name: 'Chris P.', quote: 'I’ve shopped here multiple times. Always satisfied with my orders.' },
        { name: 'Sarah M.', quote: 'I’m blown away by the quality and fit. Will definitely order again! The fabric feels incredibly soft against my skin, and the attention to detail is evident in every stitch. It’s rare to find clothes that look this good and are this comfortable at the same time.' },
        { name: 'Olivia C.', quote: 'Even my friends asked where I got these clothes. Stylish and comfy! The fit is fantastic, and the fabrics breathe well even on hot days. I love mixing and matching the pieces to create outfits that stand out without feeling overdone.' },
        { name: 'Kevin Z.', quote: 'These clothes made me feel confident and comfortable.' },
        { name: 'James L.', quote: 'As someone who’s always on the go, these outfits are perfect for me.' },
        { name: 'Lara G.', quote: 'Their eco-friendly fabric line is a huge plus for me. Love it! It’s so comforting to know that I’m supporting sustainable fashion without sacrificing style or quality. Each piece feels thoughtfully made, and the brand’s commitment to the environment really shines through.' },
        { name: 'Michael B.', quote: 'Customer service helped me pick the perfect size. Great experience!' },
        { name: 'Rachel T.', quote: 'Super fast delivery, and everything looked exactly like the pictures. I was nervous ordering online at first, but the customer service team reassured me and answered all my questions promptly. It’s become my favorite spot for updating my wardrobe!' },
        { name: 'Tommy S.', quote: 'Affordable and fashionable—what more could you want?' },
        { name: 'Alex K.', quote: 'Finding clothes that align with my style has never been easier. The variety available caters perfectly to my taste — from casual wear to something more formal for work. Plus, the colors stay vibrant even after multiple washes, which really impressed me.' },
        { name: 'Daniel H.', quote: 'Love the modern designs. Finally, clothes that feel like me.' },
        { name: 'Emily R.', quote: 'The materials feel premium, and the stitching is flawless. I appreciate how every piece fits true to size, and the cuts flatter my figure perfectly. Shopping here has transformed my wardrobe, making it both stylish and functional.' },
        { name: 'Ivan T.', quote: 'I wore it to a party and got compliments all night. A+!' },
        { name: 'Nina W.', quote: 'My new go-to store for casual and smart outfits. Highly recommended!' },
      ],

      next() {
        if (this.current < this.testimonials.length - this.visible) this.current++;
      },
      prev() {
        if (this.current > 0) this.current--;
      },
      getOpacityClass(index) {
        return (index >= this.current && index < this.current + this.visible) ? 'opacity-100' : 'opacity-40';
      }
    }
  }

</script>



<section x-data="testimonialSlider()" class="testimonials text-center p-8 relative min-h-[400px]">
  <h3 class="text-2xl font-bold mb-6 mt-6">OUR HAPPY CUSTOMERS</h3>



  <!-- Carousel -->
  <div class="overflow-hidden relative mt-10">
    <div 
      class="flex transition-transform duration-700 ease-in-out"
    >
      <template x-for="(testimonial, index) in testimonials" :key="index">
        <div 
          class="w-full sm:w-1/2 md:w-1/4 px-4 flex-shrink-0 transition-opacity duration-500"
          :class="getOpacityClass(index)"
        >
          <div class="bg-white p-4 rounded shadow h-56 overflow-y-auto">
            <p class="text-yellow-500 mb-2">⭐⭐⭐⭐⭐</p>
            <p><strong x-text="testimonial.name"></strong></p>
            <p class="italic mt-1" x-text="testimonial.quote"></p>
          </div>

        </div>
      </template>
    </div>
  </div>

  <!-- Arrows below the testimonial carousel -->
<div class="flex justify-center mt-6 gap-4">
  <button @click="prev" class="transition duration-500 ease-in-out bg-gray-200 hover:bg-black text-black hover:text-white px-5 py-2 rounded-full">
    &larr;
  </button>
  <button @click="next" class="transition duration-500 ease-in-out bg-gray-200 hover:bg-black text-black hover:text-white px-5 py-2 rounded-full">
    &rarr;
  </button>
</div>

</section>







@endsection