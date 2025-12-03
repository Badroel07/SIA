@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Breadcrumb -->
    <div class="mb-6 text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-teal-600">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800">{{ $medicine->name }}</span>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row">

            <!-- Gambar Besar -->
            <div class="md:w-1/3 bg-gray-50 flex items-center justify-center p-8 border-r border-gray-100">
                @if($medicine->image)
                <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" class="rounded-lg shadow-md max-h-80">
                @else
                <div class="text-9xl">💊</div>
                @endif
            </div>

            <!-- Informasi Detail -->
            <div class="md:w-2/3 p-8 md:p-12">
                <div class="flex items-center justify-between mb-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $medicine->category }}
                    </span>

                    <!-- Status Stok -->
                    @if($medicine->stock > 0)
                    <span class="flex items-center text-green-600 text-sm font-bold">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Stok Tersedia ({{ $medicine->stock }})
                    </span>
                    @else
                    <span class="flex items-center text-red-600 text-sm font-bold">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Stok Habis
                    </span>
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $medicine->name }}</h1>

                <div class="text-3xl font-bold text-teal-600 mb-6">
                    Rp {{ number_format($medicine->price, 0, ',', '.') }} <span class="text-sm text-gray-400 font-normal">/ pcs</span>
                </div>

                <div class="prose max-w-none text-gray-600 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi & Indikasi:</h3>
                    <p class="leading-relaxed">{{ $medicine->description }}</p>
                </div>

                <div class="border-t pt-6">
                    <div class="flex gap-4">
                        <a href="{{ route('home') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                            &larr; Kembali
                        </a>
                        <button class="flex-1 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition shadow-lg opacity-50 cursor-not-allowed" title="Fitur pembelian dimatikan" disabled>
                            Beli Sekarang (Non-Aktif)
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 text-center md:text-left">* Pembelian hanya dapat dilakukan langsung di apotek.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection