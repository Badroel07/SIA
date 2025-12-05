@extends('customer.layouts.app')

@section('content')

{{-- ========================================================================= --}}
{{-- ALPINE.JS DATA BLOCK UTAMA (Keranjang + Notifikasi) --}}
{{-- ========================================================================= --}}
<div x-data="{ 
    // State Keranjang
    cart: JSON.parse(sessionStorage.getItem('simCart')) || [],
    showCart: false,
    showConfirmClear: false,
    
    // State Toast Notification - DIUBAH JADI ARRAY
    toasts: [],
    toastId: 0, // ID unik untuk setiap toast

    // Fungsi Keranjang
    get cartTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
    },
    
    get cartTotalQty() {
        return this.cart.reduce((total, item) => total + item.qty, 0);
    },
    
    saveCart() {
        sessionStorage.setItem('simCart', JSON.stringify(this.cart));
    },

    addToCart(item, qty = 1) {
        const index = this.cart.findIndex(i => i.id === item.id);
        
        if (index > -1) {
            this.cart[index].qty += qty;
        } else {
            this.cart.push({...item, qty: qty});
        }
        
        this.saveCart();
        this.showToast(`${item.name} berhasil ditambahkan!`, 'success');
    },
    
    updateQty(id, change) {
        const index = this.cart.findIndex(i => i.id === id);
        if (index > -1) {
            let newQty = this.cart[index].qty + change;
            
            if (newQty <= 0) {
                this.removeItem(id);
                this.showToast(`Item dihapus dari keranjang.`, 'info');
            } else {
                this.cart[index].qty = newQty;
                this.saveCart();
            }
        }
    },
    
    removeItem(id) {
        this.cart = this.cart.filter(item => item.id !== id);
        this.saveCart();
    },

    // Fungsi Toast Baru - DIUBAH UNTUK SUPPORT MULTIPLE TOASTS
    showToast(message, type) {
        const id = this.toastId++;
        this.toasts.push({
            id: id,
            message: message,
            type: type,
            show: false // Mulai dengan false untuk trigger animasi
        });
        
        // Trigger animasi dengan delay kecil
        setTimeout(() => {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) toast.show = true;
        }, 10);
        
        // Auto remove setelah 3 detik
        setTimeout(() => {
            this.removeToast(id);
        }, 3000);
    },

    removeToast(id) {
        const index = this.toasts.findIndex(t => t.id === id);
        if (index > -1) {
            this.toasts[index].show = false;
            // Hapus dari array setelah animasi selesai
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 300);
        }
    },

    confirmClear() {
        this.showCart = false;
        this.showConfirmClear = true;
    },

    clearCartConfirmed() {
        this.cart = [];
        this.saveCart();
        this.showConfirmClear = false;
        this.showToast('Keranjang simulasi berhasil dikosongkan.', 'warning');
    }
}" x-init="cart.length === 0 ? [] : saveCart()" x-cloak>

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
                        class="w-full px-4 py-3 bg-gray-50 rounded-lg border-none text-gray-700 flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-600 transition">
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

                        <a href="{{ route('show', $item->slug) }}" class="w-8 h-8 rounded-full bg-blue-50 text-brand-blue flex items-center justify-center hover:bg-blue-600 hover:text-white transition" title="Lihat Detail">
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

    {{-- FLOATING CART SIMULASI --}}
    <div class="fixed bottom-4 right-4 z-40">
        <button @click="showCart = true"
            class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-xl flex items-center relative transition transform hover:scale-105">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span x-text="cartTotalQty"
                class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-xs font-bold px-2 py-1 rounded-full border-2 border-white"
                :class="{'hidden': cartTotalQty === 0}">
            </span>
        </button>
    </div>

    {{-- MODAL KERANJANG SIMULASI --}}
    <div x-show="showCart"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4"
        x-cloak>

        <div @click.outside="showCart = false"
            class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-6 transform transition-all max-h-screen overflow-y-auto">

            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Keranjang Simulasi</h3>
                <button @click="showCart = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <template x-if="cart.length > 0">
                <div>
                    <ul class="space-y-4 max-h-80 overflow-y-auto pr-2">
                        <template x-for="item in cart" :key="item.id">
                            <li class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-semibold text-gray-800" x-text="item.name"></p>
                                    <p class="text-sm text-gray-500">
                                        <span class="inline-flex items-center gap-1 border rounded-md px-1 mr-2">
                                            <button @click="updateQty(item.id, -1)" class="text-gray-500 hover:text-red-500 p-1">-</button>
                                            <span x-text="item.qty" class="font-bold text-gray-800 text-sm"></span>
                                            <button @click="updateQty(item.id, 1)" class="text-gray-500 hover:text-green-500 p-1">+</button>
                                        </span>
                                        x Rp <span x-text="item.price.toLocaleString('id-ID')"></span>
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-blue-600" x-text="`Rp ${(item.price * item.qty).toLocaleString('id-ID')}`"></span>
                                </div>
                            </li>
                        </template>
                    </ul>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xl font-bold text-gray-800">Total Simulasi</span>
                            <span class="text-2xl font-extrabold text-blue-600" x-text="`Rp ${cartTotal.toLocaleString('id-ID')}`"></span>
                        </div>

                        <button @click="confirmClear()" class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-bold transition">
                            Kosongkan Keranjang
                        </button>
                    </div>
                </div>
            </template>

            <template x-if="cart.length === 0">
                <div class="text-center py-8">
                    <p class="text-gray-500">Keranjang simulasi kosong. Silakan tambahkan obat.</p>
                </div>
            </template>
        </div>
    </div>

    {{-- MODAL KONFIRMASI KOSONGKAN KERANJANG --}}
    <div x-show="showConfirmClear"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4"
        x-cloak>

        <div @click.outside="showConfirmClear = false"
            class="bg-white w-full max-w-sm rounded-xl shadow-2xl p-6 transform transition-all">

            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center text-red-500">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c.866 0 1.34-1.01.789-1.637L12.789 4.363c-.45-.63-.17-1.637.789-1.637z"></path>
                </svg>
                Konfirmasi
            </h3>

            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin mengosongkan seluruh keranjang simulasi ini?</p>

            <div class="flex justify-end gap-3">
                <button @click="showConfirmClear = false" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                    Batal
                </button>
                <button @click="clearCartConfirmed()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition">
                    Ya, Kosongkan
                </button>
            </div>
        </div>
    </div>

    {{-- TOAST NOTIFICATION STACK - DIUBAH UNTUK SUPPORT MULTIPLE TOASTS --}}
    <div class="fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50 flex flex-col gap-2 items-center pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-full"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-full"
                class="pointer-events-auto">

                <div class="p-4 rounded-lg shadow-xl text-white font-semibold flex items-center gap-3 min-w-[300px]"
                    :class="{
                        'bg-green-500': toast.type === 'success',
                        'bg-red-500': toast.type === 'error',
                        'bg-yellow-500': toast.type === 'warning',
                        'bg-blue-500': toast.type === 'info',
                    }">

                    <template x-if="toast.type === 'success'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'warning'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c.866 0 1.34-1.01.789-1.637L12.789 4.363c-.45-.63-.17-1.637.789-1.637z"></path>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'info'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>

                    <span x-text="toast.message" class="flex-1"></span>

                    <button @click="removeToast(toast.id)" class="ml-2 hover:opacity-75">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

@endsection