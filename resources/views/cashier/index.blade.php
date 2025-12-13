@extends('cashier.layouts.app')

@section('title', 'Sistem Kasir ePharma')

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

    @keyframes pulse-ring {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(1.5);
            opacity: 0;
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

    @keyframes wave {

        0%,
        100% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(20deg);
        }

        75% {
            transform: rotate(-15deg);
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

    .animate-pulse-ring {
        animation: pulse-ring 2s ease-out infinite;
    }

    .animate-shimmer {
        animation: shimmer 2s infinite;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        background-size: 200% 100%;
    }

    .animate-wave {
        animation: wave 2s ease-in-out infinite;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
    }

    .hover-lift {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .btn-epic {
        position: relative;
        overflow: hidden;
    }

    .btn-epic::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .btn-epic:hover::before {
        left: 100%;
    }
</style>

<div class="min-h-screen p-4 sm:p-6 lg:p-8 relative">

    <!-- Decorative Background -->
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 right-1/4 w-64 h-64 bg-purple-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
    </div>

    @php
    $nowWIB = \Carbon\Carbon::now('Asia/Jakarta');
    $dateFormatted = $nowWIB->translatedFormat('l, d F Y');
    $timeFormatted = $nowWIB->format('H:i:s');
    $initialClock = "{$dateFormatted} | {$timeFormatted} WIB";
    $greeting = $nowWIB->hour < 12 ? 'Selamat Pagi' : ($nowWIB->hour < 17 ? 'Selamat Siang' : 'Selamat Malam' );
            @endphp

            <!-- Clock Badge -->
            <div class="flex justify-end mb-6 animate-slide-right">
                <div class="inline-flex items-center gap-3 px-5 py-3 glass-card rounded-2xl shadow-lg border border-gray-100">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p id="realtime-clock" class="text-gray-600 font-medium">{{ $initialClock }}</p>
                </div>
            </div>

            <!-- Main Card -->
            <div class="glass-card shadow-2xl rounded-3xl overflow-hidden border border-gray-100 animate-slide-up">

                <!-- Header with Wave Pattern -->
                <div class="relative bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 p-8 md:p-12 overflow-hidden">
                    <!-- Wave pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 320" fill="white">
                            <path d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                        </svg>
                    </div>

                    <!-- Floating decorations -->
                    <div class="absolute top-4 right-8 w-20 h-20 border border-white/20 rounded-full animate-float"></div>
                    <div class="absolute bottom-4 right-24 w-12 h-12 bg-white/10 rounded-full animate-float" style="animation-delay: 1s;"></div>

                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="text-center md:text-left">
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white/90 text-sm font-medium mb-4">
                                <span class="animate-wave inline-block">👋</span>
                                {{ $greeting }}
                            </div>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3">
                                {{ Auth::user()->name ?? 'Guest' }}
                            </h1>
                            <p class="text-blue-100 text-lg">Selamat bekerja! Semoga transaksi hari ini lancar 🚀</p>
                        </div>

                        <!-- Avatar with ring -->
                        <div class="relative">
                            <div class="absolute inset-0 bg-white/30 rounded-full animate-pulse-ring"></div>
                            <div class="relative w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white/50 shadow-2xl overflow-hidden bg-gradient-to-br from-blue-400 to-indigo-600">
                                <div class="w-full h-full flex items-center justify-center text-white text-5xl md:text-6xl font-bold">
                                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="p-8 space-y-4">
                    <a href="{{ route('cashier.transaction.index') }}" class="block">
                        <button class="btn-epic group cursor-pointer w-full flex items-center justify-center gap-4 px-8 py-5 text-xl font-bold rounded-2xl shadow-xl text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl active:scale-[0.98]">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <span>TRANSAKSI BARU</span>
                            <svg class="w-6 h-6 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </a>

                    <a href="{{ route('cashier.transaction.history') }}" class="block">
                        <button class="group cursor-pointer w-full flex items-center justify-center gap-3 px-8 py-4 text-lg font-semibold rounded-2xl border-2 border-gray-200 text-gray-700 bg-white hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 hover:border-blue-300 hover:text-blue-600 transition-all duration-300 hover:shadow-lg">
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Lihat Riwayat Transaksi
                            <svg class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </a>
                </div>

                <!-- Stats Summary -->
                <div class="px-8 pb-8">
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            Ringkasan Bulan Ini
                        </h2>

                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Stat 1 -->
                            <div class="group glass-card p-5 rounded-2xl border border-blue-100 hover:border-blue-300 transition-all duration-300 hover:shadow-xl hover-lift animate-slide-up" style="animation-delay: 0.1s;">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                                <p class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">12</p>
                            </div>

                            <!-- Stat 2 -->
                            <div class="group glass-card p-5 rounded-2xl border border-green-100 hover:border-green-300 transition-all duration-300 hover:shadow-xl hover-lift animate-slide-up" style="animation-delay: 0.2s;">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">Total Penjualan</p>
                                <p class="text-2xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Rp 5.25jt</p>
                            </div>

                            <!-- Stat 3 -->
                            <div class="group glass-card p-5 rounded-2xl border border-amber-100 hover:border-amber-300 transition-all duration-300 hover:shadow-xl hover-lift animate-slide-up" style="animation-delay: 0.3s;">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">Produk Terjual</p>
                                <p class="text-3xl font-extrabold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">156</p>
                            </div>

                            <!-- Stat 4 -->
                            <div class="group glass-card p-5 rounded-2xl border border-red-100 hover:border-red-300 transition-all duration-300 hover:shadow-xl hover-lift animate-slide-up" style="animation-delay: 0.4s;">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform animate-pulse">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">Stok Kritis</p>
                                <p class="text-3xl font-extrabold bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text text-transparent">5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Realtime Clock Script -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    function updateClock() {
                        const now = new Date();
                        const timeOptions = {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: false,
                            timeZone: 'Asia/Jakarta'
                        };
                        const dateOptions = {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        const formattedDate = now.toLocaleDateString('id-ID', dateOptions);
                        const formattedTime = now.toLocaleTimeString('id-ID', timeOptions);
                        const clockString = `${formattedDate} | ${formattedTime} WIB`;
                        const clockElement = document.getElementById('realtime-clock');
                        if (clockElement) clockElement.textContent = clockString;
                    }
                    updateClock();
                    setInterval(updateClock, 1000);
                });
            </script>

</div>

@endsection