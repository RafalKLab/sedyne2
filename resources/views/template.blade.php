<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('styles')
</head>
<body class="h-full flex flex-col">

<!-- Navigation -->
<nav class="bg-white shadow-md px-4 py-3 flex items-center justify-between md:justify-start md:flex-col md:h-screen md:w-64 md:fixed">
    <div class="text-xl font-semibold text-gray-800 md:mb-6">MyApp</div>
    <div class="hidden md:flex md:flex-col w-full space-y-2">
        <a href="#" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Dashboard</a>
        <a href="#" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Projects</a>
        <a href="#" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Settings</a>
    </div>

    <!-- Mobile nav -->
    <div class="md:hidden">
        <button id="menuBtn" class="text-gray-700 focus:outline-none">
            ☰
        </button>
        <div id="mobileMenu" class="hidden absolute top-14 left-0 right-0 bg-white shadow-lg rounded-md z-10 p-4 space-y-2">
            <a href="#" class="block text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Dashboard</a>
            <a href="#" class="block text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Projects</a>
            <a href="#" class="block text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Settings</a>
        </div>
    </div>
</nav>

<!-- Page Content -->
<main class="flex-1 md:ml-64 p-6">
    @yield('content')
</main>

<script>
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

@yield('scripts')

</body>
</html>
