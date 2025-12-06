@extends('customer.layouts.app')

@section('content')
@include('components.cart.cartLogic')

<!-- 1. HERO SECTION -->
<section class="relative pt-16 md:pt-32 pb-20 overflow-hidden">
    <div class="absolute inset-0 -z-20">
        <img src="{{ asset('img/pharmacy.png') }}" alt="Pharmacy Background" class="w-full h-full object-cover opacity-50">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-gray-50 via-gray-50/80 to-transparent -z-10"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
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
            <!-- Input Pencarian -->
            <div class="flex-grow w-full relative">
                <span class="absolute left-4 top-3.5 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama obat..."
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-lg border-none focus:ring-2 focus:ring-blue-600 text-gray-700 placeholder-gray-400">
            </div>

            <!-- Custom Dropdown Kategori -->
            <div class="w-full md:w-56 relative"
                x-data="{ open: false, selectedLabel: '{{ request('category') == 'all' ? 'Semua Kategori' : (request('category') ?: 'Semua Kategori') }}', selectedValue: '{{ request('category') ?: 'all' }}' }"
                @click.outside="open = false">

                <input type="hidden" name="category" x-model="selectedValue">

                <button type="button" @click="open = !open"
                    class="w-full px-4 py-3 bg-gray-50 rounded-lg border-none text-gray-700 flex justify-between items-center focus:outline-none focus:ring-2 transition">
                    <span class="truncate" x-text="selectedLabel"></span>
                    <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute z-30 w-full mt-2 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 overflow-hidden max-h-60 overflow-y-auto">

                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white transition"
                        @click.prevent="selectedLabel = 'Semua Kategori'; selectedValue = 'all'; open = false">
                        Semua Kategori
                    </a>

                    @foreach($categories as $cat)
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white transition"
                        @click.prevent="selectedLabel = '{{ $cat }}'; selectedValue = '{{ $cat }}'; open = false">
                        {{ $cat }}
                    </a>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold transition cursor-pointer">
                Cari
            </button>
        </form>
    </div>

    <!-- Grid Obat -->
    @if($medicines->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($medicines as $item)
        <div class="group bg-white rounded-2xl p-4 transition hover:shadow-xl border border-gray-100 hover:border-blue-100 flex flex-col">
            <!-- Image Wrapper -->
            <div class="relative bg-blue-50 rounded-xl h-48 overflow-hidden mb-4 flex items-center justify-center">
                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-brand-blue text-xs font-bold px-2 py-1 rounded">
                    {{ $item->category }}
                </span>
                @if($item->image)
                <!-- <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300"> -->
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                <svg class="w-16 h-16 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z" clip-rule="evenodd"></path>
                </svg>
                @endif
            </div>

            <h3 class="font-heading font-bold text-lg text-gray-900 mb-1 group-hover:text-brand-blue transition">{{ $item->name }}</h3>
            <p class="text-sm text-gray-500 mb-4 line-clamp-4 h-20">{{ $item->description }}</p>

            <div class="flex flex-col gap-2 justify-between mt-auto pt-2 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <span class="text-brand-teal font-bold text-lg">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    @if($item->stock > 0)
                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-700">
                        Tersedia
                    </span>
                    @else
                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-red-100 text-red-700">
                        Stok Habis
                    </span>
                    @endif
                </div>

                <div class="flex justify-end items-center gap-2">
                    @if($item->stock > 0)
                    <button type="button" @click="addToCart({ id: {{ $item->id }}, name: '{{ $item->name }}', price: {{ $item->price }} })"
                        class="flex-grow text-sm font-bold bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition">
                        + Tambah ke Keranjang
                    </button>
                    @else
                    <button type="button" disabled class="flex-grow text-sm font-bold bg-gray-300 text-gray-600 px-3 py-2 rounded-lg cursor-not-allowed">
                        Stok Kosong
                    </button>
                    @endif

                    <a href="{{ route('show', $item->id ) }}" class="w-8 h-8 rounded-full bg-blue-50 text-brand-blue flex items-center justify-center hover:bg-blue-600 hover:text-white transition" title="Lihat Detail">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
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

@include('components.cart.floatingCart')
@include('components.cart.cartModal')
@include('components.cart.toast')
@include('components.cart.confirmDelete')

@endsection