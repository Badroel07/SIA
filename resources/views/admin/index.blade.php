@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    @keyframes slideInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

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

    @keyframes slideInRight {
        0% {
            opacity: 0;
            transform: translateX(30px);
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

    @keyframes pulse-glow {

        0%,
        100% {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }

        50% {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.6);
        }
    }

    @keyframes countUp {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    .animate-slide-up {
        animation: slideInUp 0.6s ease-out forwards;
    }

    .animate-slide-left {
        animation: slideInLeft 0.6s ease-out forwards;
    }

    .animate-slide-right {
        animation: slideInRight 0.6s ease-out forwards;
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    .animate-pulse-glow {
        animation: pulse-glow 3s ease-in-out infinite;
    }

    .animate-count {
        animation: countUp 0.8s ease-out forwards;
    }

    .animate-shimmer {
        animation: shimmer 2s infinite;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        background-size: 200% 100%;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
    }

    .hover-lift {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>

<div class="space-y-8 relative">

    <!-- Decorative Background -->
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    {{-- KARTU STATISTIK UTAMA (3 Kolom Gradient) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Kartu 1: Total Stok --}}
        <div class="group relative overflow-hidden rounded-3xl animate-slide-up hover-lift" style="animation-delay: 0.1s;">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700"></div>
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700"></div>

            <!-- Decorative elements -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>

            <div class="relative p-8">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-cubes text-white text-2xl"></i>
                    </div>
                    <div class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                        Realtime
                    </div>
                </div>

                <div>
                    <p class="text-white/80 text-sm font-medium uppercase tracking-wider mb-2">Stok Tersedia</p>
                    <h2 class="text-5xl font-extrabold text-white animate-count">{{ $stats['totalStock'] }}</h2>
                </div>

                <div class="mt-6 pt-4 border-t border-white/20">
                    <p class="text-white/70 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Total unit obat di gudang
                    </p>
                </div>
            </div>
        </div>

        {{-- Kartu 2: Produk Tersedia --}}
        <div class="group relative overflow-hidden rounded-3xl animate-slide-up hover-lift" style="animation-delay: 0.2s;">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 via-green-600 to-teal-700"></div>
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gradient-to-br from-green-600 via-teal-600 to-cyan-700"></div>

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>

            <div class="relative p-8">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-capsules text-white text-2xl"></i>
                    </div>
                    <div class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                        Active
                    </div>
                </div>

                <div>
                    <p class="text-white/80 text-sm font-medium uppercase tracking-wider mb-2">Jenis Produk</p>
                    <h2 class="text-5xl font-extrabold text-white animate-count">{{ $stats['availableProducts'] }}</h2>
                </div>

                <div class="mt-6 pt-4 border-t border-white/20">
                    <p class="text-white/70 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Jenis obat dengan stok aktif
                    </p>
                </div>
            </div>
        </div>

        {{-- Kartu 3: Total Terjual --}}
        <div class="group relative overflow-hidden rounded-3xl animate-slide-up hover-lift" style="animation-delay: 0.3s;">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500 via-violet-600 to-indigo-700"></div>
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gradient-to-br from-violet-600 via-purple-600 to-pink-700"></div>

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>

            <div class="relative p-8">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-shipping-fast text-white text-2xl"></i>
                    </div>
                    <div class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                        Sold
                    </div>
                </div>

                <div>
                    <p class="text-white/80 text-sm font-medium uppercase tracking-wider mb-2">Obat Terjual</p>
                    <h2 class="text-5xl font-extrabold text-white animate-count">{{ $stats['totalSold'] }}</h2>
                </div>

                <div class="mt-6 pt-4 border-t border-white/20">
                    <p class="text-white/70 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Total unit yang telah terjual
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: GRAFIK DAN PERINGATAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri (lg:col-span-2): Kapasitas --}}
        <div class="lg:col-span-2 glass-card rounded-3xl shadow-xl border border-gray-100 overflow-hidden animate-slide-left" style="animation-delay: 0.4s;">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-warehouse text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Kapasitas Stok Gudang</h3>
                            <p class="text-sm text-gray-500">Monitoring realtime kapasitas penyimpanan</p>
                        </div>
                    </div>
                    <span class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-bold">{{ $stats['stockPercentage'] }}%</span>
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-center gap-8">
                    <!-- Circular Progress -->
                    <div class="relative w-40 h-40 flex-shrink-0">
                        <svg class="w-40 h-40 transform -rotate-90">
                            <circle cx="80" cy="80" r="70" stroke="#e5e7eb" stroke-width="12" fill="none" />
                            <circle cx="80" cy="80" r="70"
                                stroke="url(#gradient)"
                                stroke-width="12"
                                fill="none"
                                stroke-dasharray="440"
                                stroke-dashoffset="{{ 440 - (440 * $stats['stockPercentage'] / 100) }}"
                                stroke-linecap="round"
                                class="transition-all duration-1000" />
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#3b82f6" />
                                    <stop offset="100%" stop-color="#8b5cf6" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <span class="text-4xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $stats['stockPercentage'] }}%</span>
                            <span class="text-xs text-gray-500 font-medium">Terisi</span>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-transparent rounded-xl">
                            <span class="text-gray-600 font-medium">Stok Saat Ini</span>
                            <span class="text-xl font-bold text-blue-600">{{ $stats['totalStock'] }} unit</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-transparent rounded-xl">
                            <span class="text-gray-600 font-medium">Kapasitas Maksimum</span>
                            <span class="text-xl font-bold text-gray-800">{{ $totalInitialStock }} unit</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-transparent rounded-xl">
                            <span class="text-gray-600 font-medium">Status</span>
                            <span class="px-3 py-1 rounded-full text-sm font-bold 
                                {{ $stats['stockPercentage'] > 80 ? 'bg-green-100 text-green-600' : ($stats['stockPercentage'] < 30 ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600') }}">
                                {{ $stats['stockPercentage'] > 80 ? 'Optimal' : ($stats['stockPercentage'] < 30 ? 'Kritis' : 'Normal') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Peringatan Stok Rendah --}}
        <div class="glass-card rounded-3xl shadow-xl border border-gray-100 overflow-hidden animate-slide-right" style="animation-delay: 0.5s;">
            @if($lowStockMedicines->isEmpty())
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Status Stok</h3>
                        <p class="text-sm text-gray-500">Kondisi optimal</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg animate-pulse">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Stok Rendah</h3>
                        <p class="text-sm text-gray-500">Perlu restok segera</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="p-6">
                @if($lowStockMedicines->isEmpty())
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">Semua stok dalam kondisi aman</p>
                </div>
                @else
                <ul class="space-y-3">
                    @foreach($lowStockMedicines as $index => $medicine)
                    <li class="group flex justify-between items-center p-4 bg-gradient-to-r from-red-50 to-orange-50 rounded-2xl border border-red-100 hover:border-red-300 transition-all duration-300 hover:shadow-lg animate-slide-up" style="animation-delay: {{ 0.6 + ($index * 0.1) }}s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-pills text-red-500"></i>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $medicine->name }}</span>
                        </div>
                        <span class="px-3 py-1.5 bg-red-500 text-white font-bold rounded-xl text-sm shadow-lg shadow-red-500/30">
                            {{ $medicine->stock }} unit
                        </span>
                    </li>
                    @endforeach
                </ul>

                <div class="mt-6">
                    <a href="{{ route('admin.medicines.index') }}"
                        class="group flex items-center justify-center gap-2 w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        Kelola Inventaris
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection