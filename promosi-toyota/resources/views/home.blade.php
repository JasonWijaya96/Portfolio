@extends('layouts.app')

@section('content')
<section class="relative w-full h-[400px] md:h-[700px] overflow-hidden" id="heroSlider">
    <div class="hero-slide absolute inset-0 transition-opacity duration-700 flex items-center justify-center" style="opacity: 1;">
        <img src="{{ asset('images/avanza.jpg') }}" alt="Avanza" class="w-full h-full object-cover object-center md:object-fill" />
        <div class="absolute bottom-10 left-10">
            <button onclick="document.getElementById('featuredModels').scrollIntoView({ behavior: 'smooth' })" 
                class="bg-red-600 text-white px-6 py-3 rounded-full font-semibold text-lg shadow-lg
                       hover:bg-red-700 hover:scale-105 transition-transform duration-300 ease-in-out">
                See More
            </button>
        </div>
    </div>

    <div class="hero-slide absolute inset-0 transition-opacity duration-700 flex items-center justify-center" style="opacity: 0;">
        <img src="{{ asset('images/zenix.jpg') }}" alt="Zenix" class="w-full h-full object-cover object-center md:object-fill" />
        <div class="absolute bottom-10 left-10 space-y-2 text-white">
            <button onclick="document.getElementById('models').scrollIntoView({ behavior: 'smooth' })" 
                class="bg-red-600 text-white px-6 py-3 rounded-full font-semibold text-lg shadow-lg
                       hover:bg-red-700 hover:scale-105 transition-transform duration-300 ease-in-out">
                See More
            </button>
        </div>
    </div>

    <div class="hero-slide absolute inset-0 transition-opacity duration-700 flex items-center justify-center" style="opacity: 0;">
        <img src="{{ asset('images/vellfire-banner.jpg') }}" alt="Vellfire" class="w-full h-full object-cover object-center md:object-fill" />
        <div class="absolute bottom-10 left-10 space-y-2 text-white">
            <button onclick="document.getElementById('models').scrollIntoView({ behavior: 'smooth' })" 
                class="bg-red-600 text-white px-6 py-3 rounded-full font-semibold text-lg shadow-lg
                       hover:bg-red-700 hover:scale-105 transition-transform duration-300 ease-in-out">
                See More
            </button>
        </div>
    </div>

    <button id="prevSlide" 
            class="absolute top-1/2 left-5 -translate-y-1/2 bg-gray-800 text-white px-3 py-1 rounded-full
                   shadow-md hover:bg-gray-700 z-10">
        <
    </button>
    <button id="nextSlide" 
            class="absolute top-1/2 right-5 -translate-y-1/2 bg-gray-800 text-white px-3 py-1 rounded-full
                   shadow-md hover:bg-gray-700 z-10">
        >
    </button>

    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</section>

<section class="bg-black text-white py-12 px-6 md:px-12 text-center">
    <h2 class="text-4xl font-bold uppercase mb-6 tracking-wide font-russo text-red-500">OUR NEWEST MODELS</h2>

    <div class="max-w-4xl mx-auto aspect-video rounded-lg overflow-hidden shadow-lg">
        <iframe 
            width="100%" height="100%" 
            src="https://www.youtube.com/embed/6V2wMSr5Rlo?autoplay=1&mute=1&controls=1&modestbranding=1&rel=0" 
            title="YouTube video player" 
            frameborder="0"
            allow="autoplay; encrypted-media" 
            allowfullscreen>
        </iframe>
    </div>
</section>

<section class="bg-gray-50 py-16 px-6 md:px-12" id="featuredModels">
    <h2 class="text-4xl font-bold text-center mb-10 uppercase text-red-500 font-russo">
        Featured Models
    </h2>

    <div class="relative w-full flex items-center justify-center">
        <button id="prevFeatured" class="absolute left-2 md:left-5 bg-gray-800 text-white px-4 py-2 rounded-full shadow-md z-10 hover:bg-gray-700">
            <
        </button>

        <div id="sliderFeatured" class="flex gap-6 overflow-x-auto scroll-smooth w-full max-w-6xl px-4 md:px-10 py-4 snap-x snap-mandatory">
        @forelse ($featuredModels as $car)
                <div class="bg-white shadow-lg rounded-lg min-w-[280px] md:min-w-[320px] snap-center hover:scale-105 transition-transform duration-300 ease-in-out">
                    @if($car->image)
                        <img src="{{ Str::startsWith($car->image, 'showroom_images/') ? asset('storage/' . $car->image) : asset('images/' . $car->image) }}" 
                            alt="{{ $car->title ?? $car->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="bg-gray-200 w-full h-48 flex items-center justify-center text-gray-500 text-xl">
                            No Image
                        </div>
                    @endif

                    <div class="p-4">
    <h3 class="text-xl font-semibold font-russo">{{ $car->title }}</h3>
    <p class="text-gray-600 mt-2">{{ Str::limit($car->description, 100) }}</p>
</div>

                </div>
            @empty
                <p class="text-center text-gray-500 w-full">Belum ada data featured.</p>
            @endforelse
        </div>

        <button id="nextFeatured" class="absolute right-2 md:right-5 bg-gray-800 text-white px-4 py-2 rounded-full shadow-md z-10 hover:bg-gray-700">
            >
        </button>
    </div>
</section>

<section class="bg-gray-50 py-8 px-6 md:px-12" id="models">
    <h2 class="text-4xl font-bold text-center mb-10 uppercase text-red-500 font-russo">
        Models
    </h2>

    <div class="relative w-full flex items-center justify-center">
        <button id="prevModels" class="absolute left-2 md:left-5 bg-gray-800 text-white px-4 py-2 rounded-full shadow-md z-10 hover:bg-gray-700">
            <
        </button>

        <div id="sliderModels" class="flex gap-6 overflow-x-auto scroll-smooth w-full max-w-6xl px-4 md:px-10 py-4 snap-x snap-mandatory">
            @forelse ($normalModels as $car)
                <div class="bg-white shadow-lg rounded-lg min-w-[280px] md:min-w-[320px] snap-center hover:scale-105 transition-transform duration-300 ease-in-out">
                    @if($car->image)
                        <img src="{{ Str::startsWith($car->image, 'showroom_images/') ? asset('storage/' . $car->image) : asset('images/' . $car->image) }}" 
                            alt="{{ $car->title ?? $car->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="bg-gray-200 w-full h-48 flex items-center justify-center text-gray-500 text-xl">
                            No Image
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-xl font-semibold font-russo">{{ $car->title }}</h3>
                        <p class="text-gray-600 mt-2">{{ Str::limit($car->description, 100) }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 w-full">Belum ada data models.</p>
            @endforelse
        </div>

        <button id="nextModels" class="absolute right-2 md:right-5 bg-gray-800 text-white px-4 py-2 rounded-full shadow-md z-10 hover:bg-gray-700">
            >
        </button>
    </div>
</section>

<script>
    const slides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.opacity = (i === index) ? '1' : '0';
        });
    }
    showSlide(currentSlide);

    document.getElementById('nextSlide').addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    });

    document.getElementById('prevSlide').addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    });

    const autoRotate = setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }, 5000);

    const sliderFeatured = document.getElementById('sliderFeatured');
    const prevFeatured   = document.getElementById('prevFeatured');
    const nextFeatured   = document.getElementById('nextFeatured');

    prevFeatured.addEventListener('click', () => {
        sliderFeatured.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });

    nextFeatured.addEventListener('click', () => {
        sliderFeatured.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    });

    const sliderModels = document.getElementById('sliderModels');
    const prevModels   = document.getElementById('prevModels');
    const nextModels   = document.getElementById('nextModels');

    prevModels.addEventListener('click', () => {
        sliderModels.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });

    nextModels.addEventListener('click', () => {
        sliderModels.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    });
</script>

@endsection