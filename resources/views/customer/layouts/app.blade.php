<?php
$active = 'font-bold text-lg text-blue-600 border-b-4 border-blue-600';
$inactive = 'text-lg hover:text-blue-600 hover:border-b-4 border-transparent border-blue-600 transition duration-500';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePharma - Sistem Informasi Apotek Terpercaya</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')

    <!-- 1. FONT DARI GOOGLE (Inter & Poppins) -->
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

    <!-- TOP BAR -->
    <div class="bg-blue-500 text-white py-2 text-sm hidden md:block">
        <div class="container mx-auto px-4 flex justify-between items-center">
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

    <!-- NAVBAR -->
    <nav class="bg-white py-4 sticky top-0 z-50 shadow-sm border-b border-gray-100">
        <!-- PERBAIKAN 1: Hapus justify-between dari container utama -->
        <div class="container mx-auto px-4 flex items-center">

            <!-- Logo (KIRI) -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-heading font-bold text-gray-900">
                <div class="w-16 h-16 flex items-center justify-center text-white text-xs">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo ePharma">
                    <!-- <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                    </svg> -->
                </div>
                ePharma
            </a>

            <!-- Menu Links -->
            <!-- PERBAIKAN 2: Tambahkan ml-auto untuk mendorong menu ke kanan -->
            <div class="hidden md:flex items-center space-x-8 font-medium text-gray-600 ml-auto">
                <a href="{{ route('home') }}" class="@if(request()->is('/')) 
                    {{$active}} 
                @else 
                    {{$inactive}}
                @endif 
                py-4 -mb-1">Cari Obat</a>
                <a href="#" class="@if(request()->is('contact')) 
                {{$active}} 
            @else 
                {{$inactive}}
            @endif 
            py-4 -mb-1">Hubungi Kami</a>
                <a href="{{ route('about') }}" class="@if(request()->is('about')) 
                    {{$active}} 
                @else 
                    {{$inactive}}
                @endif 
                py-4 -mb-1">Tentang Kami</a>
            </div>

            <!-- Right Button (Ini akan berada tepat di sebelah menu links, atau di kanan sendiri jika menu linksnya di kanan) -->
            <div>
                <button class="md:hidden text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-20">
        <div class="container mx-auto px-4 grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">ePharma</h3>
                <p class="text-gray-400 text-sm">Menyediakan layanan dan produk obat terbaik bagi pelanggan.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Quick Links</h4>
                <ul class="text-gray-400 text-sm space-y-2">
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Layanan</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center text-gray-500 text-sm mt-12 pt-8 border-t border-gray-800">
            &copy; 2025 ePharma ITG. All rights reserved.
        </div>
    </footer>

</body>

</html>