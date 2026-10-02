<nav class="fixed top-0 left-0 w-full z-50 bg-white px-8 py-4 border-b border-gray-200 flex items-center justify-between shadow">

    <!-- Left: Logo + Nav Links -->
    <div class="flex items-center space-x-8">
        <span class="text-2xl font-extrabold text-black">SHOP.CO</span>
        <div class="hidden md:flex space-x-6 text-sm text-gray-800 font-medium">
            <a href="{{ route('categories.index') }}" class="hover:text-black flex items-center space-x-1">
                <span>Shop</span>
            </a>
            <a href="{{ route('products.on-sale') }}" class="hover:text-black">On Sale</a>
            <a href="{{ route('products.new-arrivals') }}" class="hover:text-black">New Arrivals</a>  
            <a href="{{ route('brands.index') }}" class="hover:text-black">Brands</a> 
            <a href="{{ route('home') }}" class="hover:text-black">Home</a> 
        </div>
    </div>

   
<!-- Center: Search Bar -->
<form action="{{ route('products.search') }}" method="GET" class="flex-1 max-w-xl mx-10 hidden md:block">
    <div class="relative">
        <input type="text" name="q" placeholder="Search for products..."
               class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 text-sm border border-transparent focus:border-gray-300 focus:outline-none transition" />
        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </div>
    </div>
</form>


    <!-- Right: Icons -->
    <div class="flex items-center space-x-6 text-gray-800">
        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="hover:text-black inline-block">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
    </svg>
</a>
        @auth
        <!-- Orders -->
        <a href="{{ route('orders.index') }}" class="hover:text-black inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h3l1-1h2l1 1h3a2 2 0 012 2v12a2 2 0 01-2 2z" />
            </svg>
        </a>
    @endauth


     


<!-- Profile -->
<a href="{{ route('login') }}" class="hover:text-black">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963
                 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0
                 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
    </svg>
</a>

    </div>
</nav>
