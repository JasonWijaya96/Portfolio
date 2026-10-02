<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Toyota</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logotab.png') }}">
</head>
<body class="flex flex-col min-h-screen">
<nav class="bg-white text-black py-4 px-6 md:px-8 flex justify-between items-center fixed w-full shadow-md z-50">
    <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 object-contain">

    <ul class="hidden md:flex space-x-6 text-lg">
        @foreach ([ 
            ['name' => 'Home', 'route' => 'home'],
            ['name' => 'Showroom', 'route' => 'showroom.index'],
            ['name' => 'About Us', 'route' => 'about'],
            ['name' => 'Contact Us', 'route' => 'contact']
        ] as $item)
            <li class="relative group">
                <a href="{{ route($item['route']) }}" class="hover:text-red-500 transition">
                    {{ $item['name'] }}
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
            </li>
        @endforeach
    </ul>

    <button id="menu-toggle" class="md:hidden text-black focus:outline-none text-2xl">
        ☰
    </button>
</nav>

<div id="mobile-menu" class="hidden fixed top-16 left-0 w-full bg-white shadow-md md:hidden z-50 transition-all duration-300 ease-in-out transform scale-95 opacity-0">
    <ul class="flex flex-col items-center space-y-4 py-4 text-lg">
        @foreach ([ 
            ['name' => 'Home', 'route' => 'home'],
            ['name' => 'Showroom', 'route' => 'showroom.index'],
            ['name' => 'About Us', 'route' => 'about'],
            ['name' => 'Contact Us', 'route' => 'contact']
        ] as $item)
            <li class="relative group">
                <a href="{{ route($item['route']) }}" class="hover:text-red-500 transition">
                    {{ $item['name'] }}
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
            </li>
        @endforeach
    </ul>
</div>

<div class="flex-1 mt-16">
    @yield('content')
</div>

<footer class="bg-black text-white py-8 w-full relative">
    <div class="flex flex-col items-center md:hidden space-y-4">
        <p class="text-center text-sm">&copy; 2025 Toyota. All rights reserved.</p>
        <div class="flex flex-col items-center">
            <p class="text-center mb-2">Follow Us On:</p>
            <div class="flex space-x-4 mb-4">
                <a href="https://www.instagram.com/toyota/" target="_blank">
                    <img src="{{ asset('images/Instagram.png') }}" alt="Instagram" class="w-6 h-6 hover:opacity-80">
                </a>
                <a href="https://twitter.com/ToyotaMotorCorp" target="_blank">
                    <img src="{{ asset('images/x.png') }}" alt="X" class="w-6 h-6 hover:opacity-80">
                </a>
                <a href="https://www.youtube.com/@ToyotaIndonesia" target="_blank">
                    <img src="{{ asset('images/YouTube.png') }}" alt="YouTube" class="w-8 h-6 hover:opacity-80">
                </a>
                <a href="https://www.facebook.com/Toyota" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-6 h-6 hover:opacity-80">
                </a>
            </div>
        </div>
    </div>

    <div class="hidden md:flex flex-col items-center">
        <p class="text-center text-sm mb-4">&copy; 2025 Toyota. All rights reserved.</p>
        <div class="flex flex-col items-center">
            <p class="text-center mb-2">Follow Us On:</p>
            <div class="flex space-x-4">
                <a href="https://www.instagram.com/toyota/" target="_blank">
                    <img src="{{ asset('images/Instagram.png') }}" alt="Instagram" class="w-6 h-6 hover:opacity-80">
                </a>
                <a href="https://twitter.com/ToyotaMotorCorp" target="_blank">
                    <img src="{{ asset('images/x.png') }}" alt="X" class="w-6 h-6 hover:opacity-80">
                </a>
                <a href="https://www.youtube.com/@ToyotaIndonesia" target="_blank">
                    <img src="{{ asset('images/YouTube.png') }}" alt="YouTube" class="w-8 h-6 hover:opacity-80">
                </a>
                <a href="https://www.facebook.com/Toyota" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-6 h-6 hover:opacity-80">
                </a>
            </div>
        </div>
    </div>
</footer>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.contains('hidden');

        if (isHidden) {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                mobileMenu.classList.remove('opacity-0', 'scale-95');
                mobileMenu.classList.add('opacity-100', 'scale-100');
            }, 10);
        } else {
            mobileMenu.classList.remove('opacity-100', 'scale-100');
            mobileMenu.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
        }

        menuToggle.textContent = isHidden ? 'X' : '☰';
    });
</script>

</body>
</html>
