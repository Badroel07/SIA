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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    <style>
        /* Fixes for Tailwind and Alpine.js */
        [x-cloak] {
            display: none !important;
        }

        .font-sans {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">

    {{-- WRAPPER UTAMA: x-data untuk menyimpan state sidebar --}}
    <div class="min-h-screen flex"
        x-data="{ 
            isSidebarOpen: false, {{-- DEFAULT TERTUTUP --}}
            
            // Fungsi untuk toggle sidebar
            toggleSidebar() {
                this.isSidebarOpen = !this.isSidebarOpen;
            }
        }">

        <!-- SIDEBAR (Kiri) - Lebar Ditetapkan (OVERLAY) -->
        <aside class="bg-white shadow-xl shadow-gray-200 flex flex-col fixed h-full z-50 transition-transform duration-300 w-60"
            {{-- Menggunakan transform untuk slide in/out --}}
            :class="{ '-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }">

            <!-- Brand & Tombol Tutup di dalam Sidebar (Diperbaiki strukturnya) -->
            <div class="h-16 flex items-center px-4 border-b border-gray-100 justify-end">



                {{-- Tombol Tutup (Di dalam Sidebar) --}}
                <button @click="toggleSidebar()"
                    class="text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 transition p-1.5 flex-shrink-0 ml-2">
                    <i class="fas fa-times w-5 h-5"></i>
                </button>
            </div>


            <!-- Menu Navigasi -->
            <nav class="flex-1 overflow-y-auto pt-6">
                {{-- Logo (Rata Tengah di sisa ruang) --}}
                <div class="flex-1 text-center">
                    <span class="block text-xl font-extrabold tracking-wider text-blue-600 overflow-hidden whitespace-nowrap">
                        ePharma<span class="text-gray-400">Admin</span>
                    </span>
                </div>

                <ul class="space-y-1 px-3 mt-5">

                    {{-- Menu Dasar --}}

                    <li class="mb-4">
                        <a href="{{ route('admin.dashboard') }}"
                            class="mt-2 flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-home w-5 text-center flex-shrink-0"></i>
                            <span class="overflow-hidden whitespace-nowrap {{ request()->routeIs('admin.dashboard') ? 'font-bold' : 'font-medium'}}">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.medicines.index') }}"
                            class="mt-2 flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition duration-150 {{ request()->routeIs('admin.medicines.index') ? 'bg-blue-100 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-capsules w-5 text-center flex-shrink-0"></i>
                            <span class="overflow-hidden whitespace-nowrap {{ request()->routeIs('admin.medicines.index') ? 'font-bold' : 'font-medium'}}">Manajemen Obat</span>
                        </a>
                    </li>

                    @if(Auth::check() && Auth::user()->isAdmin())
                    {{-- Judul Menu --}}
                    <li class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider overflow-hidden whitespace-nowrap">Management</li>

                    {{-- Link Manajemen Obat --}}
                    <li>
                        <a href="{{ route('admin.medicines.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150 {{ request()->routeIs('admin.medicines.*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                            <i class="fas fa-capsules w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium overflow-hidden whitespace-nowrap">Manajemen Obat</span>
                        </a>
                    </li>

                    {{-- Link Kelola Staff --}}
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                            <i class="fas fa-users-cog w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium overflow-hidden whitespace-nowrap">Kelola Staff/Kasir</span>
                        </a>
                    </li>
                    @endif

                    {{-- Menu Khusus Kasir --}}
                    @if(Auth::check() && Auth::user()->isCashier())
                    <li class="px-4 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider overflow-hidden whitespace-nowrap">Kasir</li>
                    <li>
                        <a href="{{ route('cashier.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150">
                            <i class="fas fa-cash-register w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium overflow-hidden whitespace-nowrap">Halaman Kasir</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            <!-- Footer Sidebar/Logout -->
            @auth
            <div class="p-4 border-t border-gray-100 transition-all duration-300 px-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-2 py-2 text-red-500 hover:bg-red-50 rounded-lg transition text-sm font-medium justify-start">
                        <i class="fas fa-sign-out-alt w-5 text-center flex-shrink-0"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        {{-- Backdrop untuk menutup sidebar saat overlay terbuka --}}
        <div x-show="isSidebarOpen" @click="isSidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-transparent z-40" x-cloak></div>

        <!-- KONTEN KANAN (Tidak ada margin dinamis, selalu 100% lebar) -->
        <div class="flex-1 flex flex-col min-h-screen">

            <!-- Topbar (Wadah Tombol Toggle Sidebar) -->
            <header class="bg-white p-3 shadow-md flex justify-between items-center h-16 border-b border-gray-200 sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    {{-- Tombol Toggle Pembuka (Dipindahkan ke Topbar) --}}
                    <button @click="toggleSidebar()"
                        class="text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 transition p-1.5 flex-shrink-0">
                        <i class="fas fa-bars w-5 h-5"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                </div>

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
                &copy; {{ date('Y') }} CHKL. All Rights Reserved.
            </footer>
        </div>

    </div>
    @stack('scripts')
</body>

</html>