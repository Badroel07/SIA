<?php
$active = 'font-bold text-lg text-blue-600 border-b-4 border-blue-600';
$inactive = 'text-lg hover:text-blue-600 hover:border-b-4 border-blue-600 transition duration-500';
$inactiveLogOut = 'text-lg hover:text-red-600 hover:border-b-4 border-red-600 transition duration-500';

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Class khusus untuk Heading (Judul) */
        .font-heading {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Tambahan agar scrollbar lebih rapi */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="text-gray-700 antialiased bg-gray-50">

    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">

        <nav class="bg-white py-4 sticky top-0 z-50 shadow-sm border-b border-gray-100 w-full">
            <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center">

                <div class="flex items-center gap-2">
                    <button @click="sidebarOpen = true" type="button" class="md:hidden text-gray-600 focus:outline-none p-2 rounded-md hover:bg-gray-100 transition">
                        <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <a href="{{ route('cashier.dashboard') }}" class="flex items-center gap-1 text-2xl font-heading font-bold text-gray-900 flex-shrink-0">
                        <div class="w-16 h-16 flex items-center justify-center text-white text-xs">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo ePharma">
                        </div>
                        ePharma Cashier System
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8 font-medium text-gray-600">
                    <a href="{{ route('cashier.dashboard') }}" class="{{ request()->routeIs('cashier.dashboard') ? $active : $inactive}} py-4 -mb-1">
                        Dashboard
                    </a>

                    <a href="{{ route('cashier.transaction.index') }}" class="{{ request()->routeIs('cashier.transaction.index') ? $active : $inactive}} py-4 -mb-1">
                        Transaksi
                    </a>

                    <a href="{{ route('cashier.transaction.history') }}" class="{{ request()->routeIs('cashier.transaction.history') ? $active : $inactive}} py-4 -mb-1">
                        Riwayat Transaksi
                    </a>

                    {{-- MODIFIKASI: Tombol Logout Desktop --}}
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="text-red-600 {{ request()->routeIs('') ? $active : $inactiveLogOut}} py-4 -mb-1 cursor-pointer">
                        Logout
                    </a>
                </div>
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
                <a href="{{ route('cashier.dashboard') }}" class="@if(request()->is('/')) 
                    {{$mobile_active}} 
                @else 
                    {{$mobile_inactive}}
                @endif" @click="sidebarOpen = false">Dashboard</a>

                <a href="{{ route('about') }}" class="@if(request()->is('about')) 
                    {{$mobile_active}} 
                @else 
                    {{$mobile_inactive}}
                @endif" @click="sidebarOpen = false">Tentang Kami</a>

                <div class="pt-4 border-t border-gray-100 mt-4">
                    {{-- MODIFIKASI: Tombol Logout Mobile --}}
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                        class="block px-3 py-3 rounded-lg text-lg font-medium text-red-500 hover:bg-red-50 transition">
                        Logout
                    </a>
                    <a href="#" class="block px-3 py-3 rounded-lg text-lg font-medium text-blue-500 hover:bg-blue-50 transition">Masuk/Daftar</a>
                </div>
            </nav>
        </div>
        <main>
            @yield('content')
        </main>

        <footer class="bg-gray-900 text-white py-6 mt-20">
            <div class="text-center text-gray-500 text-sm mt-5 pt-8 border-t border-gray-800">
                &copy; {{ date('Y') }} CHKL. All Rights Reserved.
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