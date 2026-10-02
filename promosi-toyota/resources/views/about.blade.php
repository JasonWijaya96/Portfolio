@extends('layouts.app')

@section('content')
<section class="relative w-full h-[400px] md:h-[500px] overflow-hidden">
    <img src="{{ asset('images/banner.png') }}" 
         alt="Toyota Banner" 
         class="absolute inset-0 w-full h-full object-cover brightness-[0.5] scale-105 transition duration-1000 ease-in-out">
    
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <h1 class="text-white text-4xl md:text-6xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            About Us
        </h1>
        <p class="mt-4 text-gray-100 text-lg md:text-xl max-w-2xl drop-shadow-md">
            Discover Toyota’s legacy of innovation, quality, and commitment to sustainable mobility.
        </p>
    </div>
</section>

<section class="w-full h-auto md:h-[400px] flex flex-col md:flex-row">
    <div class="w-full md:w-1/2 bg-gray-900 text-white flex flex-col justify-center px-8 md:px-16 py-12">
        <h2 class="text-3xl md:text-5xl font-extrabold mb-4 uppercase tracking-wide text-red-500">
            About Toyota
        </h2>
        <p class="text-gray-200 text-lg leading-relaxed">
            Founded in 1937 by <span class="text-red-400 font-semibold">Kiichiro Toyoda</span>, Toyota has become a global pioneer in automotive innovation. 
            From humble roots in Japan to a presence in over <span class="underline decoration-red-400">170 countries</span>, 
            we are driven by a passion for quality, sustainability, and transforming lives through mobility.
        </p>
    </div>

    <div class="w-full md:w-1/2 h-[300px] md:h-auto">
        <img src="{{ asset('images/about-toyota.jpg') }}" 
             alt="Toyota History" 
             class="w-full h-full object-cover">
    </div>
</section>

<section class="relative py-14 px-6 md:px-12 text-white bg-cover bg-center"
         style="background-image: url('{{ asset('images/vision-bg.jpg') }}');">
    {{-- Dark Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br from-red-800 via-black to-black opacity-80"></div>

    <div class="relative max-w-5xl mx-auto text-center">
        <h2 class="text-5xl font-extrabold mb-6 uppercase tracking-widest drop-shadow-lg">
            Our Vision
        </h2>

        <p class="text-2xl italic font-light mb-8 drop-shadow-md">
            "Creating Mobility for All"
        </p>

        <p class="text-base md:text-lg leading-relaxed drop-shadow-sm">
            We envision a future where mobility empowers everyone. By combining cutting-edge innovation with environmental 
            responsibility and social inclusivity, Toyota strives to lead the transformation toward a more sustainable and connected world.
        </p>

        {{-- Highlights --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 text-sm">
            <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                <div class="text-4xl mb-2">🚘</div>
                <p><strong>Mobility for All</strong><br>Smart, inclusive transport systems for everyone.</p>
            </div>
            <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                <div class="text-4xl mb-2">🌱</div>
                <p><strong>Sustainable Growth</strong><br>Leading carbon-neutral innovation.</p>
            </div>
            <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                <div class="text-4xl mb-2">🌐</div>
                <p><strong>Global Responsibility</strong><br>Serving society through mobility.</p>
            </div>
        </div>
    </div>
</section>

<section class="w-full h-auto md:h-[400px] flex flex-col md:flex-row">
    {{-- Gambar separuh kiri --}}
    <div class="w-full md:w-1/2 h-1/2 md:h-auto">
        <img src="{{ asset('images/history.jpg') }}" 
             alt="Toyota History" 
             class="w-full h-full object-cover">
    </div>

    {{-- Teks separuh kanan --}}
    <div class="w-full md:w-1/2 bg-gradient-to-br from-sky-700 via-blue-800 to-indigo-900 
                text-white flex items-center px-8 md:px-16 py-10">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-yellow-300 mb-6 uppercase">Our History</h2>
            <p class="text-lg text-blue-100">
                Toyota’s journey began in 1936 with the creation of the Model AA sedan, marking the birth of a legacy driven by innovation. 
                From pioneering the world-renowned Corolla to launching the groundbreaking Prius, Toyota has continuously evolved while maintaining 
                an unwavering commitment to quality and mobility for all.
            </p>
        </div>
    </div>
</section>

<section class="w-full h-auto md:h-[400px] flex flex-col md:flex-row text-white">
    <div class="w-full md:w-1/2 h-[300px] md:h-auto">
        <img src="{{ asset('images/electric.png') }}" 
             alt="Toyota Sustainability" 
             class="w-full h-full object-cover">
    </div>

    <div class="w-full md:w-1/2 bg-gradient-to-br from-green-700 via-emerald-600 to-lime-600 flex items-center px-8 md:px-16 py-10">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold mb-4 uppercase tracking-wide text-lime-100">Sustainability</h2>
            <p class="text-lg text-white">
                From carbon neutrality to zero-emission vehicles, Toyota’s commitment to the planet goes beyond products — it's embedded in our philosophy. We’re driving toward a cleaner, safer, and more connected world, where innovation meets responsibility.
            </p>
        </div>
    </div>
</section>

@endsection
