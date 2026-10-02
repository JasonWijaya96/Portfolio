<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body x-data="{ sidebarOpen: false, openProduct: false }" class="bg-gray-50 text-gray-800">
    <!-- Mobile Menu Button (visible only on small screens) -->
<button 
  @click="sidebarOpen = !sidebarOpen"
  class="md:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded shadow"
>
  <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="2"
       viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4 6h16M4 12h16M4 18h16"></path>
  </svg>
</button>

    <div class="flex min-h-screen">
        @include('components.seller-sidebar')

        <main class="flex-1 p-6 overflow-x-hidden">
            @yield('content')
        </main>
    </div>
    @yield('otherjs')
</body>
</html>
