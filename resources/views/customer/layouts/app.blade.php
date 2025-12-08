<?php
$active = 'font-bold text-lg text-blue-600 border-b-4 border-blue-600';
$inactive = 'text-lg hover:text-blue-600 hover:border-b-4 border-blue-600 transition duration-500';

// Kelas untuk link di Sidebar Mobile
$mobile_active = 'block px-3 py-3 rounded-lg text-lg font-bold text-white bg-blue-600';
$mobile_inactive = 'block px-3 py-3 rounded-lg text-lg font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePharma - Sistem Informasi Apotek Terpercaya</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    @include('components.fonts.parkin')
    @include('components.fonts.fontAwesome')
    <style>
        /* Menyembunyikan elemen sebelum Alpine.js diinisialisasi */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="text-gray-700 antialiased bg-gray-50">

    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">

        <div class="bg-blue-500 text-white py-2 text-sm hidden md:block w-full">
            <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <p>Selamat datang di ePharma. Sistem Informasi Apotek Terpercaya dan Akurat.</p>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>(0262) 123-4567</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>support@epharma@itg.ac.id</span>
                    </div>
                </div>
            </div>
        </div>

        <nav class="bg-white py-4 sticky top-0 z-50 shadow-sm border-b border-gray-100 w-full">
            <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center">

                <div class="flex items-center gap-2">
                    <button @click="sidebarOpen = true" type="button" class="md:hidden text-gray-600 focus:outline-none p-2 rounded-md hover:bg-gray-100 transition">
                        <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <a href="{{ route('home') }}" class="flex items-center gap-1 text-2xl font-heading font-bold text-gray-900 flex-shrink-0">
                        <div class="w-16 h-16 flex items-center justify-center text-white text-xs">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo ePharma">
                        </div>
                        ePharma
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8 font-medium text-gray-600">
                    <a href="{{ route('home') }}" class="@if(request()->is('/')) 
                        {{$active}} 
                    @else 
                        {{$inactive}}
                    @endif 
                    py-4 -mb-1">Cari Obat</a>
                    <a href="{{ route('about') }}" class="@if(request()->is('about')) 
                        {{$active}} 
                    @else 
                        {{$inactive}}
                    @endif 
                    py-4 -mb-1">Tentang Kami</a>
                </div>

                <!-- <div class="flex items-center md:hidden">
                    <button @click="sidebarOpen = true" type="button" class="text-gray-600 focus:outline-none p-2 rounded-md hover:bg-gray-100 transition">
                        <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div> -->
            </div>
        </nav>

        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/50 md:hidden z-[51]" aria-hidden="true" x-cloak
            @click="sidebarOpen = false">
        </div>

        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl flex flex-col pt-6 z-[52] md:hidden" x-cloak>

            <div class="px-4 flex items-center justify-between h-16">
                <h3 class="text-xl font-bold text-gray-900">ePharma</h3>
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
                <a href="{{ route('home') }}" class="@if(request()->is('/')) 
                    {{$mobile_active}} 
                @else 
                    {{$mobile_inactive}}
                @endif" @click="sidebarOpen = false">Cari Obat</a>

                <a href="{{ route('about') }}" class="@if(request()->is('about')) 
                    {{$mobile_active}} 
                @else 
                    {{$mobile_inactive}}
                @endif" @click="sidebarOpen = false">Tentang Kami</a>
            </nav>
        </div>
        <main>
            @yield('content')
        </main>

        <footer class="bg-gray-900 text-white py-12 mt-20">
            <div class="px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">ePharma</h3>
                    <p class="text-gray-400 text-sm">Menyediakan layanan dan produk obat terbaik bagi pelanggan.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="text-gray-400 text-sm space-y-2">
                        <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}">Cari Obat</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-gray-500 text-sm mt-12 pt-8 border-t border-gray-800">
                &copy; {{ date('Y') }} ePharma. All Rights Reserved.
            </div>
        </footer>

    </div>
</body>

</html>