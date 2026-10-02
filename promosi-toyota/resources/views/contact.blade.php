@extends('layouts.app')

@section('content')
<section class="relative py-20 px-6 md:px-12 min-h-[80vh] bg-cover bg-center"
         style="background-image: url('{{ asset('images/toyota-headquarters.jpg') }}');">

    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <div class="relative max-w-6xl mx-auto text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold text-red-400 mb-4 uppercase tracking-wide">Get in Touch</h1>
        <p class="text-white/90 text-lg md:text-xl mb-12">We’re here to help you. Contact us through any of the options below.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div class="bg-white bg-opacity-90 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-8 text-center text-black">
                <div class="text-5xl mb-4">📞</div>
                <h3 class="text-xl font-bold mb-2">Phone</h3>
                <p class="text-gray-700 mb-1">+62 21 500315</p>
                <p class="text-sm text-gray-600">Customer Care (Toyota Indonesia)</p>
            </div>

            <div class="bg-white bg-opacity-90 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-8 text-center text-black">
                <div class="text-5xl mb-4">✉️</div>
                <h3 class="text-xl font-bold mb-2">Email</h3>
                <p class="text-gray-700 mb-1">customercare@toyota.astra.co.id</p>
                <p class="text-sm text-gray-600">For inquiries, feedback, and support</p>
            </div>

            <div class="bg-white bg-opacity-90 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 p-8 text-center text-black">
                <div class="text-5xl mb-4">📍</div>
                <h3 class="text-xl font-bold mb-2">Head Office</h3>
                <p class="text-gray-700 mb-1">Toyota-Astra Motor</p>
                <p class="text-sm text-gray-600">Jl. Gaya Motor III No.3, Sunter II, Jakarta Utara</p>
            </div>
        </div>

        <div class="mt-16">
            <h2 class="text-2xl font-semibold mb-3">Need further assistance?</h2>
            <p class="text-white/90 mb-6">Feel free to reach out to us. We’ll get back to you as soon as possible.</p>
            <a href="mailto:customercare@toyota.astra.co.id" 
               class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-full shadow transition">
                Contact Us Now
            </a>
        </div>
    </div>
</section>
@endsection
