@extends('cashier.layouts.app')

@section('title', 'Sistem Kasir ePharma')

@section('content')

<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">

    {{-- Solusi 1: PHP sebagai nilai default (agar tidak kosong) --}}
    @php
    // Pastikan zona waktu ke WIB (Asia/Jakarta)
    $nowWIB = \Carbon\Carbon::now('Asia/Jakarta');
    $dateFormatted = $nowWIB->translatedFormat('l, d F Y');
    $timeFormatted = $nowWIB->format('H:i:s');
    $initialClock = "{$dateFormatted} | {$timeFormatted} WIB";
    @endphp

    <p id="realtime-clock" class="text-right text-gray-600 font-medium mb-4 text-sm sm:text-base">
        {{ $initialClock }}
    </p>
    {{-- END Solusi 1 --}}

    <div class="w-full bg-white shadow-xl rounded-xl p-8 space-y-8">
        {{-- KONTEN UTAMA --}}
        <div class="flex items-center justify-between pb-6 border-b border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Selamat Datang, <span>{{ Auth::user()->name ?? 'Guest' }}</span>!</h1>
            </div>

            <div class="flex-shrink-0">
                {{-- PERUBAHAN UKURAN FOTO PROFIL DI SINI --}}
                <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-full border-4 border-indigo-200 shadow-md overflow-hidden">
                    <div class="w-full h-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-3xl font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
                {{-- AKHIR PERUBAHAN --}}
            </div>
        </div>

        <div class="space-y-4">
            <a href="{{ route('cashier.transaction.index') }}" class="px-8 py-3">
                <button class="cursor-pointer w-full flex items-center justify-center px-8 py-3 border border-transparent text-lg font-medium rounded-lg shadow-xl text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-150 ease-in-out transform hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    TRANSAKSI BARU
                </button>
            </a>
            <a href="#" class="block w-full text-center px-8 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-100 transition duration-150 ease-in-out">
                Lihat Riwayat Transaksi
            </a>
        </div>

        <div class="pt-6 border-t border-gray-100">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Ringkasan Anda</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-blue-500">Total Transaksi Bulan Ini</p>
                    <p class="text-2xl font-bold text-blue-700">12</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-green-500">Total Penjualan</p>
                    <p class="text-2xl font-bold text-green-700">Rp 5.250.000</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-yellow-500">Produk Terjual</p>
                    <p class="text-2xl font-bold text-yellow-700">156</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg shadow-md">
                    <p class="text-sm text-red-500">Stok Kritis</p>
                    <p class="text-2xl font-bold text-red-700">5</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Solusi 2: Tambahkan Event Listener untuk menjamin script jalan setelah DOM siap --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateClock() {
                const now = new Date();

                // Opsi untuk format jam (HH:MM:SS) dengan zona waktu Asia/Jakarta
                const timeOptions = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false,
                    timeZone: 'Asia/Jakarta'
                };

                // Opsi untuk format tanggal yang diterjemahkan ke id-ID
                const dateOptions = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };

                // Mengambil tanggal dan waktu
                const formattedDate = now.toLocaleDateString('id-ID', dateOptions);
                const formattedTime = now.toLocaleTimeString('id-ID', timeOptions);

                // Membentuk output dan mengganti yang lama
                const clockString = `${formattedDate} | ${formattedTime} WIB`;

                const clockElement = document.getElementById('realtime-clock');
                if (clockElement) {
                    clockElement.textContent = clockString;
                }
            }

            // Panggil fungsi segera, lalu setiap 1 detik
            updateClock();
            setInterval(updateClock, 1000);
        });
    </script>

</div>

@endsection