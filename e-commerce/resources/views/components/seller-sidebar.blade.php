<!-- Sidebar -->
<aside 
  class="w-64 bg-gray-100 p-4 pt-16 flex flex-col justify-between fixed inset-y-0 left-0 z-40 transform transition-transform duration-200 ease-in-out md:static md:translate-x-0"
  :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <nav class="space-y-2">
        <!-- Dashboard -->
        {{-- <a href="/dashboard" class="block px-2 py-1 text-gray-800 hover:text-black font-semibold"> --}}
        <a href="{{ route('seller.dashboard.index') }}" class="block px-2 py-1 text-gray-800 hover:text-black font-semibold">
            Dashboard
        </a>

        <!-- Products with Dropdown -->
        <div>
            <button @click="openProduct = !openProduct" class="flex justify-between w-full px-2 py-1 text-gray-800 hover:text-black font-semibold">
                <span>Products</span>
                <span x-text="openProduct ? '▲' : '▼'" class="text-xs"></span>
            </button>

            <div x-show="openProduct" x-transition class="ml-4 mt-2 space-y-1 text-sm text-gray-600">
                {{-- <a href="/products/comments" class="block hover:text-black">Comments</a> --}}
                <a href="{{ route('seller.comments.index') }}" class="block hover:text-black">Comment</a>
                <a href="{{ route('katalogs') }}" class="block hover:text-black">Released Products</a>
                <a href="{{ route('seller.products.create') }}" class="block hover:text-black">
    Add New Products
</a>
            </div>
        </div>
    </nav>

<form method="POST" action="{{ route('logout') }}" class="mt-10 px-2">
    @csrf
    <button type="submit"
        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow flex items-center justify-center space-x-2">
        <!-- Logout Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
        </svg>
        <span>Logout</span>
    </button>
</form>
</aside>
