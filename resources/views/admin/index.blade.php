@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-8">

    {{-- KARTU STATISTIK UTAMA (3 Kolom Gradient) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Kartu 1: Total Stok (Weekly Sales style) --}}
        <div class="bg-blue-600 p-6 rounded-xl shadow-lg text-white relative overflow-hidden transition duration-300 hover:shadow-2xl">
            <i class="fas fa-cubes absolute top-[-10px] right-[-10px] text-5xl opacity-20 transform rotate-12"></i>
            <div>
                <p class="text-lg font-medium uppercase opacity-80">Stok Tersedia</p>
                <h2 class="text-4xl font-extrabold mt-2">{{ $stats['totalStock'] }}</h2>
            </div>
            <p class="text-xs mt-4 opacity-80">
                Total semua unit obat di gudang.
            </p>
        </div>

        {{-- Kartu 2: Produk Tersedia (Weekly Orders style) --}}
        <div class="bg-blue-600 p-6 rounded-xl shadow-lg text-white relative overflow-hidden transition duration-300 hover:shadow-2xl">
            <i class="fas fa-capsules absolute top-[-10px] right-[-10px] text-5xl opacity-20 transform -rotate-12"></i>
            <div>
                <p class="text-lg font-medium uppercase opacity-80">Jenis Produk Tersedia</p>
                <h2 class="text-4xl font-extrabold mt-2">{{ $stats['availableProducts'] }}</h2>
            </div>
            <p class="text-xs mt-4 opacity-80">
                Total jenis obat yang aktif stoknya.
            </p>
        </div>

        {{-- Kartu 3: Total Terjual (Visitors Online style) --}}
        <div class="bg-blue-600 p-6 rounded-xl shadow-lg text-white relative overflow-hidden transition duration-300 hover:shadow-2xl">
            <i class="fas fa-shipping-fast absolute top-[-10px] right-[-10px] text-5xl opacity-20 transform rotate-6"></i>
            <div>
                <p class="text-lg font-medium uppercase opacity-80">Obat Terjual</p>
                <h2 class="text-4xl font-extrabold mt-2">{{ $stats['totalSold'] }}</h2>
            </div>
            <p class="text-xs mt-4 opacity-80">
                Unit yang telah keluar (Estimasi).
            </p>
        </div>
    </div>

    {{-- BAGIAN 2: GRAFIK DAN PERINGATAN (Sesuai gaya Purple) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Kolom Kiri (md:col-span-2): Kapasitas dan Grafik --}}
        <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Kapasitas Stok Gudang</h3>

            <p class="text-sm text-gray-500 mb-4">Persentase stok terisi: {{ $stats['stockPercentage'] }}%</p>

            <div class="flex items-center gap-6 py-4">
                <span class="text-5xl font-extrabold text-blue-600 w-32">{{ $stats['stockPercentage'] }}%</span>
                <div class="flex-grow">
                    <div class="bg-gray-200 rounded-full h-4">
                        {{-- Progress Bar Dinamis --}}
                        <div class="h-4 rounded-full transition-all duration-700 ease-in-out"
                            style="width: {{ $stats['stockPercentage'] }}%; background-color: {{ $stats['stockPercentage'] > 80 ? '#00ff80ff' : ($stats['stockPercentage'] < 30 ? '#ff0000ff' : '#f59e0b') }}">
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-xs text-gray-500 mt-4 border-t pt-3">
                Kapasitas dihitung berdasarkan total unit stok saat ini (vs. 1200 unit kapasitas mock).
            </p>
        </div>

        {{-- Kolom Kanan: Peringatan Stok Rendah (Traffic Sources style) --}}
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Peringatan Stok Rendah</h3>

            @if($lowStockMedicines->isEmpty())
            <p class="text-gray-500 py-4 text-center">🎉 Semua stok dalam kondisi aman.</p>
            @else
            <ul class="space-y-3 pt-2">
                @foreach($lowStockMedicines as $medicine)
                <li class="flex justify-between items-center text-sm p-2 bg-red-50 rounded-lg border border-red-200">
                    <span class="font-medium text-gray-800">{{ $medicine->name }}</span>
                    <span class="font-extrabold text-red-600">{{ $medicine->stock }} unit</span>
                </li>
                @endforeach
            </ul>
            <div class="mt-4 border-t pt-3 text-right">
                <a href="{{ route('admin.medicines.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Kelola Inventaris &rarr;</a>
            </div>
            @endif
        </div>
    </div>

</div>

@endsection