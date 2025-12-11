<?php
$active = 'nav-link active font-bold text-lg text-blue-600';
$inactive = 'nav-link text-lg text-gray-600 hover:text-blue-600 transition-smooth';

// Kelas untuk link di Sidebar Mobile
$mobile_active = 'block px-4 py-3 rounded-xl text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg';
$mobile_inactive = 'block px-4 py-3 rounded-xl text-lg font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-smooth';
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

<body class="text-gray-700 antialiased bg-gradient-to-br from-gray-50 via-white to-blue-50/30">

    @include('components.cart.cartLogic')

    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">

        <!-- Top Info Banner - Enhanced with gradient -->
        <div class="bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 text-white py-2.5 text-sm hidden md:block w-full relative overflow-hidden">
            <!-- Decorative pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-1/4 w-32 h-32 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-24 h-24 bg-white rounded-full blur-2xl"></div>
            </div>
            <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center relative z-10">
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                    </svg>
                    Selamat datang di ePharma — Sistem Informasi Apotek Terpercaya dan Akurat
                </p>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center gap-2 hover:text-blue-100 transition-smooth cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>(0262) 123-4567</span>
                    </div>
                    <div class="flex items-center gap-2 hover:text-blue-100 transition-smooth cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>support@epharma.itg.ac.id</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation - Enhanced with glass effect -->
        <nav class="glass bg-white/90 py-3 sticky top-0 z-50 shadow-lg shadow-blue-900/5 border-b border-white/50 w-full">
            <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center">

                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" type="button" class="md:hidden text-gray-600 focus:outline-none p-2 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-smooth">
                        <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-heading font-bold text-gray-900 flex-shrink-0 group">
                        <div class="w-14 h-14 flex items-center justify-center transition-transform group-hover:scale-105">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo ePharma" class="">
                        </div>
                        <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">ePharma</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-10 font-medium">
                    <a href="{{ route('home') }}" class="@if(request()->is('/')) 
                        {{$active}} 
                    @else 
                        {{$inactive}}
                    @endif 
                    py-3">Cari Obat</a>
                    <a href="{{ route('about') }}" class="@if(request()->is('about')) 
                        {{$active}} 
                    @else 
                        {{$inactive}}
                    @endif 
                    py-3">Tentang Kami</a>
                </div>
            </div>
        </nav>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm md:hidden z-[51]" aria-hidden="true" x-cloak
            @click="sidebarOpen = false">
        </div>

        <!-- Mobile Sidebar - Enhanced -->
        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl flex flex-col z-[52] md:hidden" x-cloak>

            <!-- Sidebar Header -->
            <div class="px-5 flex items-center justify-between h-20 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">ePharma</h3>
                </div>
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600 p-2 rounded-xl hover:bg-gray-100 transition-smooth">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('home') }}" class="@if(request()->is('/')) 
                    {{$mobile_active}} 
                @else 
                    {{$mobile_inactive}}
                @endif flex items-center gap-3" @click="sidebarOpen = false">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Obat
                </a>

                <a href="{{ route('about') }}" class="@if(request()->is('about')) 
                    {{$mobile_active}} 
                @else 
                    {{$mobile_inactive}}
                @endif flex items-center gap-3" @click="sidebarOpen = false">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tentang Kami
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="px-4 py-4 border-t border-gray-100 bg-gray-50">
                <p class="text-xs text-gray-500 text-center">© {{ date('Y') }} ePharma</p>
            </div>
        </div>

        <main class="animate-fade-in">
            @yield('content')
        </main>

        <!-- Footer - Modernized -->
        <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16 mt-20 relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-500 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
            </div>

            <div class="px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid md:grid-cols-4 gap-10">
                    <!-- Brand Section -->
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center p-2">
                                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                            </div>
                            <h3 class="text-2xl font-bold">ePharma</h3>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-md">
                            Menyediakan layanan dan produk obat terbaik bagi pelanggan. Kami berkomitmen memberikan solusi kesehatan yang terpercaya dan akurat untuk kebutuhan Anda.
                        </p>
                        <!-- Social Icons -->
                        <div class="flex gap-4 mt-6">
                            <a href="#" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-blue-600 flex items-center justify-center transition-smooth hover:-translate-y-1">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-blue-400 flex items-center justify-center transition-smooth hover:-translate-y-1">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-pink-600 flex items-center justify-center transition-smooth hover:-translate-y-1">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-bold mb-5 text-lg">Quick Links</h4>
                        <ul class="text-gray-400 text-sm space-y-3">
                            <li>
                                <a href="{{ route('about') }}" class="hover:text-white hover:translate-x-1 inline-flex items-center gap-2 transition-smooth">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Tentang Kami
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}" class="hover:text-white hover:translate-x-1 inline-flex items-center gap-2 transition-smooth">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Cari Obat
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="font-bold mb-5 text-lg">Hubungi Kami</h4>
                        <ul class="text-gray-400 text-sm space-y-3">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Jl. Contoh No. 123, Kota, Indonesia</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>(0262) 123-4567</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>support@epharma.itg.ac.id</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="text-center text-gray-500 text-sm mt-14 pt-8 border-t border-gray-700/50">
                    <p>© {{ date('Y') }} <span class="text-white font-semibold">ePharma</span>. All Rights Reserved. Made with <span class="text-red-400">❤</span> in Indonesia</p>
                </div>
            </div>
        </footer>

    </div>

    @stack('modals')

    </div> {{-- Close cartLogic wrapper --}}
</body>

</html>