<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>


    <title>Document</title>
</head>
<body class="flex flex-col min-h-screen pt-16">

    <!-- Navbar stays at top -->
    <x-navbar />

    <!-- Main grows to fill the space -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer pushed to bottom -->
    <x-footer />

    @stack('scripts')
</body>
</html>
