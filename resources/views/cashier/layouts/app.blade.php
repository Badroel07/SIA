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
        /* Menyembunyikan elemen sebelum Alpine.js diinisialisasi */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="text-gray-700 antialiased bg-gradient-to-br from-gray-50 via-white to-blue-50/20" x-cloak>

    <div @keydown.escape.window="sidebarOpen = false">

        <!-- Enhanced Navigation -->
        <nav class="glass bg-white/90 py-3 sticky top-0 z-50 shadow-lg shadow-blue-900/5 border-b border-white/50 w-full">
            <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center">

                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" type="button" class="md:hidden text-gray-600 focus:outline-none p-2 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-smooth">
                        <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <a href="{{ route('cashier.dashboard') }}" class="flex items-center gap-2 text-xl font-heading font-bold text-gray-900 flex-shrink-0 group">
                        <div class="w-12 h-12 flex items-center justify-center transition-transform group-hover:scale-105">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo ePharma" class="">
                        </div>
                        <span class="hidden sm:inline"><span class="text-gradient">ePharma</span> Cashier</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8 font-medium">
                    <a href="{{ route('cashier.dashboard') }}" class="{{ request()->routeIs('cashier.dashboard') ? $active : $inactive}} py-3">
                        Dashboard
                    </a>

                    <a href="{{ route('cashier.transaction.index') }}" class="{{ request()->routeIs('cashier.transaction.index') ? $active : $inactive}} py-3">
                        Transaksi
                    </a>

                    <a href="{{ route('cashier.transaction.history') }}" class="{{ request()->routeIs('cashier.transaction.history') ? $active : $inactive}} py-3">
                        Riwayat
                    </a>

                    {{-- Tombol Logout Desktop --}}
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="{{ $inactiveLogOut }} py-3 cursor-pointer flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </nav>

        <div x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/50 md:hidden z-[51]" aria-hidden="true"
            @click="sidebarOpen = false">
        </div>

        <div x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl flex flex-col pt-6 z-[52] md:hidden">

            <div class="px-4 flex items-center justify-between h-16">
                <h3 class="text-xl font-bold text-gray-900">ePharma</h3>
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
                <!-- Menu Mobile yang disesuaikan dengan Topbar -->
                <a href="{{ route('cashier.dashboard') }}"
                    class="{{ request()->routeIs('cashier.dashboard') ? $mobile_active : $mobile_inactive }}"
                    @click="sidebarOpen = false; window.location.href='{{ route('cashier.dashboard') }}'">
                    Dashboard
                </a>

                <a href="{{ route('cashier.transaction.index') }}"
                    class="{{ request()->routeIs('cashier.transaction.index') ? $mobile_active : $mobile_inactive }}"
                    @click="sidebarOpen = false; window.location.href='{{ route('cashier.transaction.index') }}'">
                    Transaksi
                </a>

                <a href="{{ route('cashier.transaction.history') }}"
                    class="{{ request()->routeIs('cashier.transaction.history') ? $mobile_active : $mobile_inactive }}"
                    @click="sidebarOpen = false; window.location.href='{{ route('cashier.transaction.history') }}'">
                    Riwayat Transaksi
                </a>

                <div class="pt-4 border-t border-gray-100 mt-4">
                    {{-- MODIFIKASI: Tombol Logout Mobile --}}
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                        class="block px-3 py-3 rounded-lg text-lg font-medium text-red-500 hover:bg-red-50 transition"
                        @click="sidebarOpen = false">
                        Logout
                    </a>
                </div>
            </nav>
        </div>
        <main class="animate-fade-in">
            @yield('content')
        </main>

        <footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white py-8 mt-20">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-8 h-8 brightness-0 invert opacity-70">
                        <span class="font-semibold">ePharma Cashier</span>
                    </div>
                    <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} ePharma. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
        {{-- FORM LOGOUT TERSEMBUNYI (Wajib di dalam body) --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        {{-- END FORM LOGOUT --}}
    </div>
    @stack('scripts')
</body>

</html>