<?php
$active = 'nav-link active font-bold text-lg text-blue-600';
$inactive = 'nav-link text-lg text-gray-600 hover:text-blue-600 transition-smooth';
$inactiveLogOut = 'logout-link text-lg text-red-500 hover:text-red-600 transition-smooth';

// Kelas untuk link di Sidebar Mobile
$mobile_active = 'flex items-center gap-3 px-4 py-3 rounded-xl text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg';
$mobile_inactive = 'flex items-center gap-3 px-4 py-3 rounded-xl text-lg font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-smooth';
?>

<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }" x-init="sidebarOpen = false">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePharma - Sistem Informasi Apotek Terpercaya</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    @include('components.fonts.parkin')
    @include('components.fonts.fontAwesome')

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Sidebar Animations */
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

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-slide-left {
            animation: slideInLeft 0.3s ease-out forwards;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="text-gray-700 antialiased bg-gradient-to-br from-gray-50 via-white to-blue-50/20" x-cloak>

    <div @keydown.escape.window="sidebarOpen = false">

        <!-- Enhanced Navigation with Glass Effect -->
        <nav class="bg-white/90 backdrop-blur-lg py-3 sticky top-0 z-50 shadow-lg shadow-blue-900/5 border-b border-white/50 w-full">
            <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center">

                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" type="button" class="md:hidden text-gray-600 focus:outline-none p-2 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                        <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <a href="{{ route('cashier.dashboard') }}" class="flex items-center gap-2 text-xl font-heading font-bold text-gray-900 flex-shrink-0 group">
                        <div class="w-12 h-12 flex items-center justify-center transition-transform group-hover:scale-105">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo ePharma" class="">
                        </div>
                        <span class="hidden sm:inline"><span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">ePharma</span> Cashier</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-2 font-medium">
                    <a href="{{ route('cashier.dashboard') }}"
                        class="group flex items-center gap-2 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('cashier.dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('cashier.transaction.index') }}"
                        class="group flex items-center gap-2 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('cashier.transaction.index') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Transaksi
                    </a>

                    <a href="{{ route('cashier.transaction.history') }}"
                        class="group flex items-center gap-2 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('cashier.transaction.history') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat
                    </a>

                    <!-- Logout Button Desktop -->
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="group flex items-center gap-2 px-4 py-2.5 rounded-xl text-red-500 hover:bg-red-50 hover:text-red-600 transition-all duration-300 cursor-pointer ml-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm md:hidden z-[51]" aria-hidden="true"
            @click="sidebarOpen = false">
        </div>

        <!-- Mobile Sidebar - Modern Style like Admin -->
        <div x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-400 transform"
            x-transition:enter-start="-translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
            class="fixed inset-y-0 left-0 w-80 bg-gradient-to-br from-white via-white to-blue-50/30 shadow-2xl flex flex-col z-[52] md:hidden overflow-hidden">

            <!-- Decorative Background -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-gradient-to-br from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-gradient-to-tr from-green-400/15 to-cyan-400/15 rounded-full blur-3xl" style="animation: pulse 3s ease-in-out infinite; animation-delay: 1s;"></div>
            </div>

            <!-- Header -->
            <div class="relative px-6 flex items-center justify-between h-24 border-b border-gray-100/50 bg-gradient-to-r from-green-600 via-emerald-500 to-teal-600">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-2 left-10 w-16 h-16 border border-white/30 rounded-full animate-ping" style="animation-duration: 3s;"></div>
                </div>

                <div class="flex items-center gap-3 relative z-10">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-cash-register text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight">ePharma</h3>
                        <p class="text-green-100 text-xs font-medium">Cashier Panel</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="relative z-10 text-white/80 hover:text-white p-2.5 rounded-xl hover:bg-white/20 backdrop-blur-sm transition-all duration-300 hover:rotate-90 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-5 py-8 space-y-3 overflow-y-auto relative z-10">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4 px-4 flex items-center gap-2">
                    <span class="w-8 h-px bg-gradient-to-r from-gray-300 to-transparent"></span>
                    Menu Kasir
                    <span class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></span>
                </p>

                <!-- Dashboard -->
                <a href="{{ route('cashier.dashboard') }}"
                    class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] 
                   {{ request()->routeIs('cashier.dashboard') 
                       ? 'bg-gradient-to-r from-green-600 via-emerald-500 to-teal-600 text-white shadow-xl shadow-green-500/30'
                       : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-teal-50 hover:shadow-lg' }}"
                    @click="sidebarOpen = false"
                    style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.1s;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 
                        {{ request()->routeIs('cashier.dashboard') 
                            ? 'bg-white/20 shadow-inner'
                            : 'bg-green-100 text-green-600 group-hover:bg-green-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110' }}">
                        <i class="fas fa-home text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-base block">Dashboard</span>
                        <span class="text-xs opacity-70">Halaman utama</span>
                    </div>
                </a>

                <!-- Transaksi -->
                <a href="{{ route('cashier.transaction.index') }}"
                    class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] 
                   {{ request()->routeIs('cashier.transaction.index') 
                       ? 'bg-gradient-to-r from-green-600 via-emerald-500 to-teal-600 text-white shadow-xl shadow-green-500/30'
                       : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-teal-50 hover:shadow-lg' }}"
                    @click="sidebarOpen = false"
                    style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.2s;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 
                        {{ request()->routeIs('cashier.transaction.index') 
                            ? 'bg-white/20 shadow-inner'
                            : 'bg-blue-100 text-blue-600 group-hover:bg-blue-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110' }}">
                        <i class="fas fa-shopping-cart text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-base block">Transaksi Baru</span>
                        <span class="text-xs opacity-70">Buat penjualan</span>
                    </div>
                </a>

                <!-- Riwayat -->
                <a href="{{ route('cashier.transaction.history') }}"
                    class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] 
                   {{ request()->routeIs('cashier.transaction.history') 
                       ? 'bg-gradient-to-r from-green-600 via-emerald-500 to-teal-600 text-white shadow-xl shadow-green-500/30'
                       : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-teal-50 hover:shadow-lg' }}"
                    @click="sidebarOpen = false"
                    style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.3s;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 
                        {{ request()->routeIs('cashier.transaction.history') 
                            ? 'bg-white/20 shadow-inner'
                            : 'bg-purple-100 text-purple-600 group-hover:bg-purple-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110' }}">
                        <i class="fas fa-history text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-base block">Riwayat Transaksi</span>
                        <span class="text-xs opacity-70">Lihat semua transaksi</span>
                    </div>
                </a>
            </nav>

            <!-- Footer Logout -->
            <div class="relative z-10 px-5 py-5 border-t border-gray-100/50 bg-gradient-to-r from-gray-50 to-white">
                <a href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                    class="group w-full flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 hover:shadow-lg"
                    @click="sidebarOpen = false">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center transition-all duration-300 group-hover:bg-red-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </div>
                    <div class="flex-1 text-left">
                        <span class="font-bold text-base block">Logout</span>
                        <span class="text-xs text-red-400">Keluar dari sistem</span>
                    </div>
                </a>
            </div>
        </div>

        <main>
            @yield('content')
        </main>

        <!-- Hidden Logout Forms -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    @stack('modals')
    @stack('scripts')
</body>

</html>