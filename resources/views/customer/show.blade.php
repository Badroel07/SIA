@extends('customer.layouts.app')

@section('content')

@include('components.cart.cartLogic')

{{-- Menampilkan tombol kembali ke katalog --}}
<div class="container mx-auto px-4 pt-10 pb-4">
    <a href="javascript:history.back()" class="text-blue-600 hover:text-blue-800 font-medium transition duration-300 flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Katalog
    </a>
</div>

<section class="container mx-auto px-4 py-8 md:py-12">
    <div class="bg-white rounded-xl shadow-xl p-6 md:p-10 border border-gray-100">

        <div class="flex flex-col md:flex-row gap-10">

            <!-- Kiri: Gambar Obat -->
            <div class="md:w-1/3 flex-shrink-0 bg-gray-50 rounded-lg p-6 flex items-center justify-center">
                @if($medicine->image)
                <!-- <img src="{{ Storage::url($medicine->image) }}" alt="{{ $medicine->name }}" class="w-full max-h-96 object-contain rounded-md shadow-lg"> -->
                <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" class="w-full max-h-96 object-contain rounded-md shadow-lg">
                @else
                <svg class="w-40 h-40 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z" clip-rule="evenodd"></path>
                </svg>
                @endif
            </div>

            <!-- Kanan: Detail Informasi -->
            <div class="md:w-2/3">
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-600 uppercase">{{ $medicine->category }}</span>

                <h1 class="text-4xl font-heading font-extrabold text-gray-900 mt-3 mb-4">{{ $medicine->name }}</h1>

                <div class="mb-6 flex items-center gap-4 text-gray-700">
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($medicine->price, 0, ',', '.') }}</p>

                    @if($medicine->stock > 0)
                    <span class="text-sm font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">Stok Tersedia ({{ $medicine->stock }})</span>
                    @else
                    <span class="text-sm font-semibold px-3 py-1 rounded-full bg-red-100 text-red-700">Stok Habis</span>
                    @endif
                </div>

                <!-- Ringkasan Deskripsi -->
                <p class="text-gray-600 leading-relaxed border-b pb-6 mb-6">{{ $medicine->description }}</p>

                <!-- Tombol (Simulasi Keranjang) -->
                @if($medicine->stock > 0)
                <button type="button" @click="addToCart({ id: {{ $medicine->id }}, name: '{{ $medicine->name }}', price: {{ $medicine->price }} })"
                    class="w-full md:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition transform hover:scale-105">
                    <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                </button>
                @else
                <button disabled class="w-full md:w-auto px-8 py-3 bg-gray-300 text-gray-600 font-bold rounded-lg cursor-not-allowed">
                    Stok Kosong
                </button>
                @endif

            </div>
        </div>

        <!-- Detail Teknis (Tab/Accordion) -->
        <div class="mt-12">
            <h2 class="text-3xl font-heading font-bold text-gray-800 mb-6 border-b pb-2">Informasi Produk Detail</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- 1. Indikasi dan Cara Penggunaan -->
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                    <h3 class="text-xl font-bold text-blue-700 mb-3 text-center">
                        <i class="fas fa-prescription-bottle-alt"></i> Indikasi & Dosis
                    </h3>
                    <p class="text-gray-700 mb-4">
                        {{-- Karena di DB belum ada kolom indikasi, kita gunakan description atau mock data --}}
                        <span class="font-bold">Indikasi Utama<br></span>
                        {{ $medicine->full_indication }}
                    </p>
                    <p class="text-gray-700 border-t pt-3">
                        <span class="font-bold">Cara Penggunaan<br></span>
                        @if(isset($medicine->usage_detail))
                        {{ $medicine->usage_detail }}
                        @else
                        Konsultasikan dengan apoteker atau dokter Anda.
                        @endif
                    </p>
                </div>

                <!-- 2. Efek Samping dan Larangan -->
                <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                    <h3 class="text-xl font-bold text-red-700 mb-3 text-center">
                        <i class="fas fa-exclamation-triangle"></i> Efek Samping & Larangan
                    </h3>
                    <p class="text-gray-700 mb-4">
                        Efek Samping :@if(isset($medicine->side_effects))
                        {{ $medicine->side_effects }}
                        @else
                        Belum ada data efek samping yang dicatat.
                        @endif
                    </p>
                    <p class="text-gray-700 border-t pt-3">
                        Kontraindikasi (Larangan) :@if(isset($medicine->contraindications))
                        {{ $medicine->contraindications }}
                        @else
                        Hati-hati pada pasien dengan gangguan fungsi ginjal/hati.
                        @endif
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>




{{-- Pastikan Alpine.js x-data block (untuk cart) tetap ada, 
     karena kita memanggil addToCart di view ini --}}
<div x-data="{ 
    cart: JSON.parse(sessionStorage.getItem('simCart')) || [],
    showCart: false,
    
    get cartTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
    },
    
    saveCart() {
        sessionStorage.setItem('simCart', JSON.stringify(this.cart));
    },

    addToCart(item, qty = 1) {
        // Logika penambahan item
        const index = this.cart.findIndex(i => i.id === item.id);
        if (index > -1) { this.cart[index].qty += qty; } 
        else { this.cart.push({...item, qty: qty}); }
        this.saveCart();
        this.showCart = true;
        // Gunakan notifikasi modal yang lebih bagus, tapi pakai alert untuk sementara
        alert(`${item.name} berhasil ditambahkan ke keranjang!`); 
    },
    
    removeItem(id) {
        this.cart = this.cart.filter(item => item.id !== id);
        this.saveCart();
    },

    clearCart() {
        if(confirm('Yakin ingin mengosongkan keranjang?')) {
            this.cart = [];
            this.saveCart();
        }
    }
}" x-init="saveCart()">
    {{-- Floating Cart UI akan berada di sini (disembunyikan di view show ini, atau ditaruh di layout app) --}}
</div>

@include('components.cart.floatingCart')
@include('components.cart.cartModal')
@include('components.cart.toast')
@include('components.cart.confirmDelete')
@endsection