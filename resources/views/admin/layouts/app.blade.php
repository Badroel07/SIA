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

        <!-- SIDEBAR (Kiri) - Enhanced -->
        <aside x-cloak
            class="bg-gradient-to-b from-white via-white to-gray-50 shadow-2xl shadow-gray-200/50 flex flex-col fixed h-full z-50 transition-transform duration-300 w-64 border-r border-gray-100"
            :class="{ '-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }">

            <!-- Header with Close Button -->
            <div class="h-16 flex items-center px-4 border-b border-gray-100 justify-between bg-gradient-to-r from-blue-50/50 to-white">
                <span class="text-lg font-bold text-gradient">ePharma</span>

                {{-- Close Button --}}
                <button @click="toggleSidebar()"
                    class="text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-100 transition-smooth p-2">
                    <i class="fas fa-times w-4 h-4"></i>
                </button>
            </div>


            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto pt-4 px-3">

                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i class="fas fa-home w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.medicines.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth {{ request()->routeIs('admin.medicines.index') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i class="fas fa-capsules w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium">Manajemen Obat</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth {{ request()->routeIs('admin.users.index') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                            <i class="fa-solid fa-circle-user w-5 text-center flex-shrink-0"></i>
                            <span class="font-medium">Manajemen User</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Footer Sidebar/Logout -->
            @auth
            <div class="p-4 border-t border-gray-100 bg-gradient-to-r from-red-50/50 to-white">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-red-500 hover:bg-red-50 rounded-xl transition-smooth text-sm font-medium">
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

            <!-- Topbar - Enhanced with glass effect -->
            <header class="glass bg-white/80 p-4 shadow-lg shadow-gray-200/30 flex justify-between items-center h-16 border-b border-white/50 sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    {{-- Toggle Button --}}
                    <button @click="toggleSidebar()"
                        class="text-gray-500 hover:text-blue-600 rounded-xl hover:bg-blue-50 transition-smooth p-2">
                        <i class="fas fa-bars w-5 h-5"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-600 hidden sm:block">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-blue-500/30">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-6 animate-fade-in">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="p-4 text-center text-xs text-gray-400 border-t border-gray-100 bg-white/50">
                &copy; {{ date('Y') }} <span class="font-semibold text-gray-500">ePharma Admin</span>. All Rights Reserved.
            </footer>
        </div>

    </div>
    @stack('scripts')
</body>

</html>