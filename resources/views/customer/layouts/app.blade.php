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

        /* Sidebar Stagger Animation */
        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
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

        <!-- Mobile Sidebar - Enhanced with Modern Animations -->
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-400 transform" x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="-translate-x-full opacity-0"
            class="fixed inset-y-0 left-0 w-80 bg-gradient-to-br from-white via-white to-blue-50/30 shadow-2xl flex flex-col z-[52] md:hidden overflow-hidden" x-cloak>

            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-gradient-to-br from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-gradient-to-tr from-purple-400/15 to-pink-400/15 rounded-full blur-3xl" style="animation: pulse 3s ease-in-out infinite; animation-delay: 1s;"></div>
            </div>

            <!-- Sidebar Header with Animated Logo -->
            <div class="relative px-6 flex items-center justify-between h-24 border-b border-gray-100/50 bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600">
                <!-- Animated background pattern -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-2 left-10 w-16 h-16 border border-white/30 rounded-full animate-ping" style="animation-duration: 3s;"></div>
                    <div class="absolute bottom-2 right-16 w-8 h-8 border border-white/20 rounded-full animate-ping" style="animation-duration: 4s;"></div>
                </div>

                <div class="flex items-center gap-3 relative z-10">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-9 h-9 drop-shadow-sm">
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight">ePharma</h3>
                        <p class="text-blue-100 text-xs font-medium">Apotek Digital</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="relative z-10 text-white/80 hover:text-white p-2.5 rounded-xl hover:bg-white/20 backdrop-blur-sm transition-all duration-300 hover:rotate-90 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Sidebar Navigation with Stagger Animation -->
            <nav class="flex-1 px-5 py-8 space-y-3 overflow-y-auto relative z-10">
                <!-- Menu Label -->
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4 px-4 flex items-center gap-2">
                    <span class="w-8 h-px bg-gradient-to-r from-gray-300 to-transparent"></span>
                    Menu Navigasi
                    <span class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></span>
                </p>

                <!-- Nav Items with Stagger Animation -->
                <a href="{{ route('home') }}"
                    class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] 
                   @if(request()->is('/')) 
                       bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 text-white shadow-xl shadow-blue-500/30
                   @else 
                       text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:shadow-lg
                   @endif"
                    @click="sidebarOpen = false"
                    style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.1s;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 
                        @if(request()->is('/')) 
                            bg-white/20 shadow-inner
                        @else 
                            bg-blue-100 text-blue-600 group-hover:bg-blue-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110
                        @endif">
                        <svg class="w-6 h-6 @if(request()->is('/')) animate-pulse @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-base block">Cari Obat</span>
                        <span class="text-xs opacity-70">Temukan obat yang Anda butuhkan</span>
                    </div>
                    <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('about') }}"
                    class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] 
                   @if(request()->is('about')) 
                       bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 text-white shadow-xl shadow-blue-500/30
                   @else 
                       text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:shadow-lg
                   @endif"
                    @click="sidebarOpen = false"
                    style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.2s;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 
                        @if(request()->is('about')) 
                            bg-white/20 shadow-inner
                        @else 
                            bg-indigo-100 text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110
                        @endif">
                        <svg class="w-6 h-6 @if(request()->is('about')) animate-bounce @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-base block">Tentang Kami</span>
                        <span class="text-xs opacity-70">Kenali ePharma lebih dekat</span>
                    </div>
                    <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Decorative Card -->
                <div class="mt-8 p-5 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white relative overflow-hidden shadow-xl" style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.3s;">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -right-2 -top-2 w-12 h-12 bg-white/10 rounded-full"></div>
                    <div class="relative z-10">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-sm mb-1">Butuh Bantuan?</h4>
                        <p class="text-xs text-blue-100 leading-relaxed">Hubungi layanan pelanggan kami</p>
                        <p class="text-sm font-bold mt-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            (0262) 123-4567
                        </p>
                    </div>
                </div>
            </nav>

            <!-- Sidebar Footer with Animation -->
            <div class="relative z-10 px-5 py-5 border-t border-gray-100/50 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-800">ePharma</p>
                        <p class="text-xs text-gray-500">© {{ date('Y') }} All Rights Reserved</p>
                    </div>
                </div>
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