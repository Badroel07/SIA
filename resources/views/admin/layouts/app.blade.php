<?php
// Pastikan Auth Facade sudah tersedia
use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - ePharma</title>
    @vite('resources/css/app.css')
    {{-- Memuat Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Fixes for Tailwind and Alpine.js */
        [x-cloak] {
            display: none !important;
        }

        .font-sans {
            font-family: 'Poppins', sans-serif;
        }

        /* Mengatur transisi untuk Alpine.js */
        .sidebar-transition {
            transition: width 300ms ease-in-out, margin-left 300ms ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

    {{-- WRAPPER UTAMA: x-data untuk menyimpan state sidebar --}}
    <div class="min-h-screen flex"
        x-data="{ 
            isSidebarOpen: true, 
            
            // Fungsi untuk toggle sidebar
            toggleSidebar() {
                this.isSidebarOpen = !this.isSidebarOpen;
            }
        }">

        <!-- SIDEBAR (Kiri) - Lebar Dinamis -->
        <aside class="bg-white shadow-xl shadow-gray-200 flex flex-col fixed h-full z-30 transition-all duration-300"
            :class="{ 'w-60': isSidebarOpen, 'w-16': !isSidebarOpen }">

            <!-- Brand & Tombol Toggle -->
            <div class="h-16 flex items-center p-2 border-b border-gray-100">

                {{-- Tombol Toggle Sidebar (Diposisikan di KANAN HEADER) --}}
                <div class="w-full flex"
                    :class="{ 'justify-between': isSidebarOpen, 'justify-center': !isSidebarOpen }">

                    {{-- Teks Logo (Hanya tampil saat terbuka) --}}
                    <span class="text-xl font-extrabold tracking-wider text-blue-600 overflow-hidden whitespace-nowrap"
                        x-show="isSidebarOpen" x-transition:enter.duration.500ms x-transition:leave.duration.50ms x-cloak>
                        ePharma<span class="text-gray-400">Admin</span>
                    </span>

                    {{-- Tombol Toggle --}}
                    <button @click="toggleSidebar()"
                        class="text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 transition p-1.5 flex-shrink-0">

                        {{-- Icon Toggle --}}
                        <i class="fas w-5 h-5 transition-transform duration-300"
                            :class="{ 'fa-times': isSidebarOpen, 'fa-bars': !isSidebarOpen }">
                        </i>
                    </button>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 overflow-y-auto pt-6">
                <ul class="space-y-1 px-3">

                    {{-- Menu Dasar --}}
                    <li class="mb-4">
                        <a href="{{ route('admin.dashboard') }}"
                            class="mt-2 flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700' }}"
                            :class="{ 'justify-start': isSidebarOpen, 'justify-center': !isSidebarOpen }">
                            <i class="fas fa-home w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium overflow-hidden whitespace-nowrap" x-show="isSidebarOpen" x-transition.duration.300ms x-cloak>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.medicines.index') }}"
                            class="mt-2 flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition duration-150 {{ request()->routeIs('admin.medicines.index') ? 'bg-blue-100 text-blue-600' : 'text-gray-700' }}"
                            :class="{ 'justify-start': isSidebarOpen, 'justify-center': !isSidebarOpen }">
                            <i class="fas fa-capsules w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium overflow-hidden whitespace-nowrap" x-show="isSidebarOpen" x-transition.duration.300ms x-cloak>Manajemen Obat</span>
                        </a>
                    </li>

                    @if(Auth::check() && Auth::user()->isAdmin())
                    {{-- Judul Menu --}}
                    <li class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider overflow-hidden whitespace-nowrap" x-show="isSidebarOpen" x-cloak>Management</li>

                    {{-- Link Manajemen Obat --}}
                    <li>
                        <a href="{{ route('admin.medicines.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150 {{ request()->routeIs('admin.medicines.*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}"
                            :class="{ 'justify-start': isSidebarOpen, 'justify-center': !isSidebarOpen }">
                            <i class="fas fa-capsules w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium overflow-hidden whitespace-nowrap" x-show="isSidebarOpen" x-cloak>Manajemen Obat</span>
                        </a>
                    </li>

                    {{-- Link Kelola Staff --}}
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}"
                            :class="{ 'justify-start': isSidebarOpen, 'justify-center': !isSidebarOpen }">
                            <i class="fas fa-users-cog w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium overflow-hidden whitespace-nowrap" x-show="isSidebarOpen" x-cloak>Kelola Staff/Kasir</span>
                        </a>
                    </li>
                    @endif

                    {{-- Menu Khusus Kasir --}}
                    @if(Auth::check() && Auth::user()->isCashier())
                    <li class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider overflow-hidden whitespace-nowrap" x-show="isSidebarOpen" x-cloak>Kasir</li>
                    <li>
                        <a href="{{ route('cashier.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150"
                            :class="{ 'justify-start': isSidebarOpen, 'justify-center': !isSidebarOpen }">
                            <i class="fas fa-cash-register w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium overflow-hidden whitespace-nowrap" x-show="isSidebarOpen" x-cloak>Halaman Kasir</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            <!-- Footer Sidebar/Logout -->
            @auth
            <div class="p-4 border-t border-gray-100 transition-all duration-300"
                :class="{ 'px-4': isSidebarOpen, 'px-2': !isSidebarOpen }">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-2 py-2 text-red-500 hover:bg-red-50 rounded-lg transition text-sm font-medium"
                        :class="{ 'justify-start': isSidebarOpen, 'justify-center': !isSidebarOpen }">
                        <i class="fas fa-sign-out-alt w-5 text-center flex-shrink-0"></i>
                        <span x-show="isSidebarOpen" x-cloak>Logout</span>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- KONTEN KANAN -->
        {{-- Jarak dorong konten diatur oleh margin-left dinamis --}}
        <div class="flex-1 flex flex-col min-h-screen sidebar-transition"
            :class="{ 'ml-60': isSidebarOpen, 'ml-16': !isSidebarOpen }">

            <!-- Topbar (Sederhana - Tanpa Tombol Toggle di sini) -->
            <header class="bg-white p-3 shadow-md flex justify-between items-center h-16 border-b border-gray-200 sticky top-0 z-20">
                <h1 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <!-- Footer Kecil -->
            <footer class="p-4 text-center text-xs text-gray-400 border-t border-gray-200">
                &copy; {{ date('Y') }} ePharma Staff Panel. IT Garut.
            </footer>
        </div>

    </div>

</body>

</html>

@include('admin.medicine.create')