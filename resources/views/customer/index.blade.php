@extends('customer.layouts.app')

@section('content')

<!-- 1. HERO SECTION - Enhanced -->
<section class="relative pt-20 md:pt-32 pb-24 overflow-hidden">
    <!-- Background image with overlay -->
    <div class="absolute inset-0 -z-20">
        <img src="{{ asset('img/pharmacy.png') }}" alt="Pharmacy Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-white via-white/95 to-white/70"></div>
    </div>

    <!-- Decorative blobs -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute top-20 right-10 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-40 w-56 h-56 bg-indigo-400/20 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 md:pr-10">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-6 animate-slide-in">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Apotek Terpercaya #1
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-bold text-gray-900 leading-tight mb-6 animate-slide-in" style="animation-delay: 0.1s;">
                    Makes Your Health <br>
                    Better Will Makes <br>
                    Us <span class="text-gradient">Better</span>
                </h1>
                <p class="text-gray-600 text-lg mb-8 max-w-md leading-relaxed font-medium animate-slide-in" style="animation-delay: 0.2s;">
                    ePharma menyediakan obat-obatan primer dan layanan kesehatan terbaik setiap hari untuk Anda dan keluarga.
                </p>

                <!-- CTA Button -->
                <a href="#katalog" class="inline-flex items-center gap-2 btn-primary px-8 py-3.5 rounded-xl text-lg shadow-lg hover:shadow-xl transition-all animate-slide-in" style="animation-delay: 0.3s;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Obat Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 2. SEARCH & CATALOG SECTION - Enhanced -->
<div id="katalog" class="container mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900">
            Temukan <span class="text-gradient">Obat</span> Anda
        </h2>
        <p class="text-gray-500 mt-3 max-w-lg mx-auto">Cari dari berbagai macam obat-obatan berkualitas dengan harga terjangkau</p>
        <div class="h-1 w-20 bg-gradient-to-r from-blue-600 to-indigo-600 mx-auto mt-4 rounded-full"></div>
    </div>

    <!-- Search & Filter Form - Enhanced with AJAX -->
    <div class="card-modern p-6 md:p-8 mb-12 -mt-4 relative z-20 max-w-5xl mx-auto border border-gray-100/50">
        <form action="{{ route('home') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center"
            x-data="{
                searchTimeout: null,
                loading: false,
                performSearch() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.loading = true;
                        const formData = new FormData($el);
                        const params = new URLSearchParams(formData);
                        
                        fetch('{{ route('home') }}?' + params.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'text/html'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            //  Parse HTML and update results
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newResults = doc.querySelector('#medicine-results');
                            const currentResults = document.querySelector('#medicine-results');
                            
                            if (newResults && currentResults) {
                                currentResults.innerHTML = newResults.innerHTML;
                            }
                            
                            this.loading = false;
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            this.loading = false;
                        });
                    }, 400);
                }
            }">
            <!-- Input Pencarian -->
            <div class="flex-grow w-full relative group">
                <span class="absolute left-4 top-3.5 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama obat..."
                    @input="performSearch()"
                    class="input-modern w-full !pl-12 pr-4 py-3.5 text-gray-700 placeholder-gray-400">
            </div>

            <!-- Custom Dropdown Kategori -->
            <div class="w-full md:w-64 relative"
                x-data="{ open: false, selectedLabel: '{{ request('category') == 'all' ? 'Semua Kategori' : (request('category') ?: 'Semua Kategori') }}', selectedValue: '{{ request('category') ?: 'all' }}' }"
                @click.outside="open = false">

                <input type="hidden" name="category" x-model="selectedValue" @change="performSearch()">

                <button type="button" @click="open = !open"
                    class="input-modern w-full px-4 py-3.5 text-gray-700 flex justify-between items-center cursor-pointer">
                    <span class="truncate" x-text="selectedLabel"></span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    class="absolute z-30 w-full mt-2 rounded-xl shadow-xl bg-white ring-1 ring-black/5 overflow-hidden max-h-60 overflow-y-auto">

                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-600 hover:text-white transition-smooth"
                        @click.prevent="selectedLabel = 'Semua Kategori'; selectedValue = 'all'; open = false">
                        Semua Kategori
                    </a>

                    @foreach($categories as $cat)
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-600 hover:text-white transition-smooth"
                        @click.prevent="selectedLabel = '{{ $cat }}'; selectedValue = '{{ $cat }}'; open = false">
                        {{ $cat }}
                    </a>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn-primary w-full md:w-auto px-8 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!loading">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24" x-show="loading" x-cloak>
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Cari
            </button>
        </form>
    </div>

    <!-- Results Container -->
    <div id="medicine-results">
        @if($medicines->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($medicines as $item)
            <div class="group card-modern p-5 flex flex-col hover-lift">
                <!-- Image Wrapper -->
                <div class="relative bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl h-48 overflow-hidden mb-4 flex items-center justify-center">
                    <span class="absolute top-3 left-3 badge-primary z-10">
                        {{ $item->category }}
                    </span>
                    @if($item->image)
                    <img src="{{ Storage::disk('s3')->url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <svg class="w-16 h-16 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z" clip-rule="evenodd"></path>
                    </svg>
                    @endif
                </div>

                <h3 class="font-heading font-bold text-lg text-gray-900 mb-1 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $item->name }}</h3>
                <p class="text-sm text-gray-500 mb-4 line-clamp-3 h-16 leading-relaxed">{{ $item->description }}</p>

                <div class="flex flex-col gap-3 justify-between mt-auto pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-gradient">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        @if($item->stock > 0)
                        <span class="badge-success">
                            <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Tersedia
                        </span>
                        @else
                        <span class="badge-danger">
                            Stok Habis
                        </span>
                        @endif
                    </div>

                    <div class="flex justify-end items-center gap-2">
                        @if($item->stock > 0)
                        <button type="button" @click="addToCart({ id: {{ $item->id }}, name: '{{ $item->name }}', price: {{ $item->price }} })"
                            class="flex-grow text-sm font-bold btn-primary py-2.5 rounded-xl flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah
                        </button>
                        @else
                        <button type="button" disabled class="flex-grow text-sm font-bold bg-gray-200 text-gray-500 py-2.5 rounded-xl cursor-not-allowed">
                            Stok Kosong
                        </button>
                        @endif

                        <a href="{{ route('show', $item->id ) }}" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-smooth flex-shrink-0" title="Lihat Detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="text-center py-20 bg-gradient-to-br from-gray-50 to-blue-50/30 rounded-2xl border-2 border-dashed border-gray-200">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-gray-500 text-xl font-medium">Tidak ada obat yang cocok dengan pencarianmu.</p>
            <p class="text-gray-400 mt-2">Coba kata kunci atau kategori lain</p>
        </div>
        @endif
    </div> {{-- Close medicine-results --}}
</div> {{-- Close katalog container --}}

@push('modals')
@include('components.cart.floatingCart')
@include('components.cart.cartModal')
@include('components.cart.toast')
@include('components.cart.confirmDelete')
@endpush

@endsection