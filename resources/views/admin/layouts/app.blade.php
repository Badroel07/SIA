<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - ePharma</title>
    @vite('resources/css/app.css')
    @include('components.fonts.parkin')
    @include('components.fonts.fontAwesome')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Fixes for Tailwind and Alpine.js */
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

        @keyframes swing {
            20% {
                transform: rotate(15deg);
            }

            40% {
                transform: rotate(-10deg);
            }

            60% {
                transform: rotate(5deg);
            }

            80% {
                transform: rotate(-5deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .animate-swing {
            animation: swing 1s ease-in-out;
            transform-origin: top center;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gradient-to-br from-gray-100 via-gray-50 to-blue-50/20 font-sans antialiased">
    <div class="min-h-screen flex"
        x-data="{ 
            isSidebarOpen: false, {{-- DEFAULT TERTUTUP --}}
            
            // Fungsi untuk toggle sidebar
            toggleSidebar() {
                this.isSidebarOpen = !this.isSidebarOpen;
            }
        }">

        <!-- SIDEBAR Admin - Modern with Animations -->
        <aside x-cloak x-show="isSidebarOpen"
            x-transition:enter="transition ease-out duration-400 transform"
            x-transition:enter-start="-translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
            class="fixed inset-y-0 left-0 w-80 bg-gradient-to-br from-white via-white to-blue-50/30 shadow-2xl flex flex-col z-50 overflow-hidden">

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
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight">ePharmaAdmin</h3>
                        <p class="text-blue-100 text-xs font-medium">Panel Administrasi</p>
                    </div>
                </div>
                <button @click="toggleSidebar()" class="relative z-10 text-white/80 hover:text-white p-2.5 rounded-xl hover:bg-white/20 backdrop-blur-sm transition-all duration-300 hover:rotate-90 hover:scale-110">
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
                    Menu Admin
                    <span class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></span>
                </p>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] 
                   {{ request()->routeIs('admin.dashboard') 
                       ? 'bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 text-white shadow-xl shadow-blue-500/30'
                       : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:shadow-lg' }}"
                    style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.1s;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 
                        {{ request()->routeIs('admin.dashboard') 
                            ? 'bg-white/20 shadow-inner'
                            : 'bg-blue-100 text-blue-600 group-hover:bg-blue-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110' }}">
                        <i class="fas fa-home text-lg {{ request()->routeIs('admin.dashboard') ? 'animate-pulse' : '' }}"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-base block">Dashboard</span>
                        <span class="text-xs opacity-70">Ringkasan statistik</span>
                    </div>
                    <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Manajemen Obat -->
                <a href="{{ route('admin.medicines.index') }}"
                    class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] 
                   {{ request()->routeIs('admin.medicines.*') 
                       ? 'bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 text-white shadow-xl shadow-blue-500/30'
                       : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:shadow-lg' }}"
                    style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.2s;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 
                        {{ request()->routeIs('admin.medicines.*') 
                            ? 'bg-white/20 shadow-inner'
                            : 'bg-green-100 text-green-600 group-hover:bg-green-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110' }}">
                        <i class="fas fa-capsules text-lg {{ request()->routeIs('admin.medicines.*') ? 'animate-bounce' : '' }}"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-base block">Manajemen Obat</span>
                        <span class="text-xs opacity-70">Kelola data produk</span>
                    </div>
                    <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Manajemen User -->
                <a href="{{ route('admin.users.index') }}"
                    class="group flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] 
                   {{ request()->routeIs('admin.users.*') 
                       ? 'bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 text-white shadow-xl shadow-blue-500/30'
                       : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:shadow-lg' }}"
                    style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.3s;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 
                        {{ request()->routeIs('admin.users.*') 
                            ? 'bg-white/20 shadow-inner'
                            : 'bg-purple-100 text-purple-600 group-hover:bg-purple-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110' }}">
                        <i class="fas fa-users text-lg {{ request()->routeIs('admin.users.*') ? 'animate-pulse' : '' }}"></i>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-base block">Manajemen User</span>
                        <span class="text-xs opacity-70">Kelola akun pengguna</span>
                    </div>
                    <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Admin Info Card -->
                <div class="mt-8 p-5 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl text-white relative overflow-hidden shadow-xl" style="animation: slideInLeft 0.3s ease-out forwards; animation-delay: 0.4s;">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -right-2 -top-2 w-12 h-12 bg-white/10 rounded-full"></div>
                    <div class="relative z-10">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h4 class="font-bold text-sm mb-1">Admin Panel</h4>
                        <p class="text-xs text-indigo-100 leading-relaxed">Anda memiliki akses penuh ke sistem</p>
                    </div>
                </div>
            </nav>

            <!-- Sidebar Footer with Logout -->
            @auth
            <div class="relative z-10 px-5 py-5 border-t border-gray-100/50 bg-gradient-to-r from-gray-50 to-white">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="group w-full flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 hover:shadow-lg">
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center transition-all duration-300 group-hover:bg-red-500 group-hover:text-white group-hover:shadow-lg group-hover:scale-110">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </div>
                        <div class="flex-1 text-left">
                            <span class="font-bold text-base block">Logout</span>
                            <span class="text-xs text-red-400">Keluar dari sistem</span>
                        </div>
                        <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        {{-- Backdrop untuk menutup sidebar saat overlay terbuka --}}
        <div x-show="isSidebarOpen" @click="isSidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-40" x-cloak></div>

        <!-- KONTEN KANAN (Tidak ada margin dinamis, selalu 100% lebar) -->
        <div class="flex-1 flex flex-col min-h-screen">

            <!-- Topbar - Ultra Modern & Sexy -->
            <header class="relative bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100/50 sticky top-0 z-30 transition-all duration-300">
                <!-- Decorative Gradient Line at Bottom -->
                <div class="absolute bottom-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>

                <div class="flex justify-between items-center px-4 sm:px-6 py-3">
                    <!-- Left: Toggle & Title -->
                    <div class="flex items-center gap-4 sm:gap-6">
                        <button @click="toggleSidebar()" class="group p-2.5 rounded-xl text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 hover:scale-105 outline-none focus:ring-2 focus:ring-blue-100">
                            <div class="w-6 h-5 flex flex-col justify-between items-end group-hover:items-center transition-all duration-300">
                                <span class="w-full h-0.5 bg-current rounded-full transition-all duration-300 group-hover:w-3/4"></span>
                                <span class="w-3/4 h-0.5 bg-current rounded-full transition-all duration-300 group-hover:w-full"></span>
                                <span class="w-1/2 h-0.5 bg-current rounded-full transition-all duration-300 group-hover:w-3/4"></span>
                            </div>
                        </button>

                        <div class="flex flex-col">
                            <h1 class="text-xl sm:text-2xl font-extrabold bg-gradient-to-r from-gray-800 to-indigo-600 bg-clip-text text-transparent flex items-center gap-2">
                                @yield('title', 'Dashboard')
                                <span class="hidden sm:inline-block w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                            </h1>
                            <p class="text-xs text-gray-400 font-medium hidden sm:block tracking-wide">
                                ADMIN CONTROL CENTER
                            </p>
                        </div>
                    </div>

                    <!-- Right: Actions & Profile -->
                    <div class="flex items-center gap-3 sm:gap-6">

                        <!-- Date Display (Desktop Only) -->
                        <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-gray-50/80 rounded-full border border-gray-100 hover:border-blue-200 transition-colors group cursor-default">
                            <i class="far fa-calendar-alt text-blue-500 group-hover:rotate-12 transition-transform"></i>
                            <span class="text-sm font-semibold text-gray-600">{{ date('d M Y') }}</span>
                        </div>

                        <!-- Notification Bell with Pulse -->
                        <button class="relative p-2.5 text-gray-400 hover:text-blue-600 transition-colors duration-300 rounded-xl hover:bg-blue-50 group">
                            <i class="far fa-bell text-xl group-hover:animate-swing"></i>
                            <span class="absolute top-2.5 right-3 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full animate-ping"></span>
                            <span class="absolute top-2.5 right-3 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
                        </button>

                        <!-- Vertical Separator -->
                        <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>

                        <!-- User Profile -->
                        <div class="flex items-center gap-3 pl-1 group cursor-pointer">
                            <div class="hidden sm:block text-right">
                                <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ Auth::user()->name ?? 'Administrator' }}</p>
                                <p class="text-xs text-blue-500 font-medium">Super Admin</p>
                            </div>
                            <div class="relative">
                                <!-- Avatar Ring -->
                                <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 p-[2px] shadow-lg shadow-blue-500/20 group-hover:shadow-blue-500/40 transition-all duration-300 group-hover:scale-105">
                                    <div class="w-full h-full bg-white rounded-full flex items-center justify-center overflow-hidden">
                                        <!-- Initials Fallback -->
                                        <span class="text-lg font-black bg-gradient-to-br from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <!-- Status Dot -->
                                <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-6 animate-fade-in">
                @yield('content')
            </main>

            <!-- Footer
            <footer class="p-4 text-center text-xs text-gray-400 border-t border-gray-100 bg-white/50">
                &copy; {{ date('Y') }} <span class="font-semibold text-gray-500">ePharma Admin</span>. All Rights Reserved.
            </footer> -->
        </div>

    </div>
    @stack('modals')
    @stack('scripts')
</body>

</html>