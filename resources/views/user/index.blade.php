@extends('layouts.app')

@section('content')

<!-- 1. HERO SECTION -->
<!-- Ubah bg-gray-50 jadi relative agar bisa menampung absolute background -->
<section class="relative pt-16 md:pt-32 pb-20 overflow-hidden">

    <!-- A. BACKGROUND IMAGE (Rak Obat / Interior) -->
    <div class="absolute inset-0 -z-20">
        <img src="{{ asset('img/pharmacy.png') }}"
            alt="Pharmacy Background"
            class="w-full h-full object-cover opacity-50">
        <!-- opacity-30 agar tidak terlalu mencolok -->
    </div>

    <!-- B. GRADIENT OVERLAY (Efek Fade ke Kiri) -->
    <!-- from-gray-50 (kiri solid) -> via-gray-50/90 (tengah agak transparan) -> to-transparent (kanan bening) -->
    <div class="absolute inset-0 bg-gradient-to-r from-gray-50 via-gray-50/80 to-transparent -z-10"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row items-center">

            <!-- Left Text Content -->
            <div class="md:w-1/2 md:pr-10">
                <h1 class="text-4xl md:text-6xl font-heading font-bold text-gray-900 leading-tight mb-6">
                    Makes Your Health <br>
                    Better Will Makes <br>
                    Us <span class="text-brand-blue">Better</span>
                </h1>
                <p class="text-gray-600 text-lg mb-8 max-w-md leading-relaxed font-medium">
                    ePharma menyediakan obat-obatan primer dan layanan kesehatan terbaik setiap hari untuk Anda.
                </p>
            </div>


        </div>
    </div>
</section>

<!-- 2. SEARCH & CATALOG SECTION -->
<div id="katalog" class="container mx-auto px-4 py-16">

    <div class="text-center mb-12">
        <h2 class="text-3xl font-heading font-bold text-gray-900">Cari Obat</h2>
        <div class="h-1 w-20 bg-brand-teal mx-auto mt-4 rounded"></div>
    </div>

    <!-- Search & Filter Form -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 mb-12 -mt-8 relative z-20 max-w-5xl mx-auto">
        <form action="{{ route('home') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">

            <div class="flex-grow w-full relative">
                <span class="absolute left-4 top-3.5 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama obat..."
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-lg border-none focus:ring-2 focus:ring-brand-teal text-gray-700 placeholder-gray-400">
            </div>

            <div class="w-full md:w-1/4">
                <select name="category" class="w-48 px-2 py-3 bg-gray-50 rounded-lg border-none focus:ring-2 focus:ring-brand-teal text-gray-700 cursor-pointer">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-900 text-white px-8 py-3 rounded-lg font-bold transition cursor-pointer">
                Cari
            </button>
        </form>
    </div>

    <!-- Grid Obat -->
    @if($medicines->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($medicines as $item)
        <div class="group bg-white rounded-2xl p-4 transition hover:shadow-xl border border-gray-100 hover:border-blue-100">
            <!-- Image Wrapper -->
            <div class="relative bg-blue-50 rounded-xl h-48 overflow-hidden mb-4 flex items-center justify-center">
                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-brand-blue text-xs font-bold px-2 py-1 rounded">
                    {{ $item->category }}
                </span>
                @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                <svg class="w-16 h-16 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z" clip-rule="evenodd"></path>
                </svg>
                @endif
            </div>

            <h3 class="font-heading font-bold text-lg text-gray-900 mb-1 group-hover:text-brand-blue transition">{{ $item->name }}</h3>
            <p class="text-sm text-gray-500 mb-4 line-clamp-2 h-10">{{ $item->description }}</p>

            <div class="flex items-center justify-between mt-auto">
                <span class="text-brand-teal font-bold text-lg">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                <a href="{{ route('show', $item->slug) }}" class="w-8 h-8 rounded-full bg-blue-50 text-brand-blue flex items-center justify-center hover:bg-brand-blue hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-12 flex justify-center">
        {{ $medicines->links() }}
    </div>
    @else
    <div class="text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
        <p class="text-gray-500 text-lg">Tidak ada obat yang cocok dengan pencarianmu.</p>
    </div>
    @endif
</div>

@endsection