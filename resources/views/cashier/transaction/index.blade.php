@extends('cashier.layouts.app')

@section('title', 'Transaksi Kasir ePharma')

@section('content')

<style>
    @keyframes slideInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        0% {
            opacity: 0;
            transform: translateX(20px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes pulse-subtle {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.02);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .animate-slide-up {
        animation: slideInUp 0.5s ease-out forwards;
    }

    .animate-slide-right {
        animation: slideInRight 0.5s ease-out forwards;
    }

    .animate-fade-in {
        animation: fadeIn 0.4s ease-out forwards;
    }

    .animate-pulse-subtle {
        animation: pulse-subtle 2s ease-in-out infinite;
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
    }

    .hover-lift {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.2);
    }

    .product-card:hover {
        border-color: #6366f1;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }
</style>

@php
$cartItems = Session::get('cart', []);
$subtotal = 0;
$diskon = 0;
foreach ($cartItems as $item) { $subtotal += $item['subtotal']; }
$total = $subtotal - $diskon;
@endphp

{{-- Flash Notifications --}}
@if (session('success'))
<div id="flash-message" class="fixed top-24 right-4 z-[100] glass-card border-l-4 border-green-500 px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-slide-right">
    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
    </div>
    <div>
        <p class="font-bold text-gray-800">Berhasil!</p>
        <p class="text-gray-600 text-sm">{{ session('success') }}</p>
    </div>
</div>
@endif
@if (session('error'))
<div id="flash-message" class="fixed top-24 right-4 z-[100] glass-card border-l-4 border-red-500 px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-slide-right">
    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </div>
    <div>
        <p class="font-bold text-gray-800">Error!</p>
        <p class="text-gray-600 text-sm">{{ session('error') }}</p>
    </div>
</div>
@endif

<div class="min-h-screen p-4 lg:p-8" x-data="cashierApp">
    <!-- Background Decorations -->
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-green-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    {{-- Header (Outside Grid) --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-500/30">
            <i class="fas fa-cash-register text-2xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Transaksi Baru</h1>
            <p class="text-gray-500">Pilih produk dan tambahkan ke keranjang</p>
        </div>
    </div>

    {{-- Main Grid: Search+Products | Cart --}}
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- LEFT SIDE: PRODUCTS --}}
        <div class="flex-1 space-y-6">

            {{-- Search & Filter --}}
            <div class="bg-white p-5 rounded-2xl shadow-lg border border-gray-100">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-grow relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-green-50 group-focus-within:bg-green-100 flex items-center justify-center transition-colors">
                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" x-model="search" placeholder="Cari nama obat..."
                            class="w-full pl-16 pr-4 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 placeholder-gray-400 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-300 focus:bg-white">
                    </div>

                    <select x-model="category"
                        class="px-5 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition-all duration-300 focus:bg-white">
                        <option value="all">Semua Kategori</option>
                        @foreach ($existingCategories as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Product Grid --}}
            <div id="medicine-grid-results">
                <!-- Empty State -->
                <div x-show="filteredMedicines.length === 0" class="bg-white text-center py-16 rounded-3xl border border-gray-100" x-cloak>
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-pills text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-xl text-gray-600 font-bold">Tidak ada obat ditemukan</p>
                    <p class="text-gray-400 mt-2">Coba ganti kata kunci atau filter</p>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4" x-show="filteredMedicines.length > 0">
                    <template x-for="medicine in filteredMedicines" :key="medicine.id">
                        <div class="product-card bg-white rounded-2xl overflow-hidden border-2 border-gray-100 hover:border-green-300 hover:shadow-lg transition-all duration-300">
                            {{-- Product Image --}}
                            <div class="relative h-28 overflow-hidden bg-gradient-to-br from-green-50 to-emerald-50">
                                <template x-if="medicine.image">
                                    <img class="product-image w-full h-full object-cover transition-transform duration-500 hover:scale-105" :src="'/storage/' + medicine.image" :alt="medicine.name">
                                </template>
                                <template x-if="!medicine.image">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </template>

                                {{-- Category Badge --}}
                                <span class="absolute top-2 left-2 px-2 py-1 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-xs font-bold rounded-lg shadow" x-text="medicine.category.charAt(0).toUpperCase() + medicine.category.slice(1)"></span>

                                {{-- Stock Badge --}}
                                <template x-if="medicine.stock <= 5">
                                    <span class="absolute top-2 right-2 px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-lg animate-pulse">
                                        <span x-text="medicine.stock + ' left'"></span>
                                    </span>
                                </template>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4 text-center">
                                <p class="font-bold text-gray-800 truncate text-sm" x-text="medicine.name"></p>
                                <p class="text-lg font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mt-1" x-text="'Rp ' + formatPrice(medicine.price)"></p>
                                <p class="text-xs text-gray-400 mt-1">Stok: <span x-text="medicine.stock"></span></p>

                                <button @click="openMedicineDetailModal(medicine.id)" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium mt-2 inline-block hover:underline">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </button>
                            </div>

                            {{-- Add to Cart Form --}}
                            <div class="px-4 pb-4">
                                <div class="flex gap-2">
                                    <button @click="addToCart(medicine)" :disabled="medicine.stock == 0"
                                        class="w-full flex items-center justify-center gap-2 py-2 rounded-xl font-bold text-sm transition-all duration-300"
                                        :class="medicine.stock == 0 ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-lg shadow-green-500/30 hover:shadow-green-500/50'">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </div>
                                <p x-show="medicine.stock == 0" class="text-xs text-red-500 text-center mt-2 font-medium">Stok Habis</p>
                            </div>
                        </div>
                    </template>
                </div>


            </div>
        </div>

        {{-- RIGHT SIDE: CART (Sticky, aligned with search bar) --}}
        <div class="flex-1">
            <div class="sticky top-20" style="height: fit-content;">
                <div class="bg-white p-6 rounded-3xl shadow-lg border border-gray-100 space-y-5" id="cart-section-wrapper">
                    {{-- Cart Header --}}
                    <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Keranjang</h2>
                            <p class="text-sm text-gray-500"><span x-text="cartCount"></span> item</p>
                        </div>
                    </div>

                    {{-- Empty Cart State --}}
                    <div x-show="cartCount === 0" class="text-center py-8" x-cloak>
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-shopping-basket text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Keranjang kosong</p>
                        <p class="text-gray-400 text-sm">Tambahkan produk dari katalog</p>
                    </div>

                    {{-- Cart Items --}}
                    <div class="space-y-3 max-h-[40vh] overflow-y-auto" id="cart-items" x-show="cartCount > 0">
                        <template x-for="item in cartItems" :key="item.id">
                            <div class="group flex justify-between items-center p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 relative overflow-hidden transform hover:-translate-y-1"
                                x-transition:enter="transition-all cubic-bezier(0.34, 1.56, 0.64, 1) duration-500"
                                x-transition:enter-start="opacity-0 translate-x-10 scale-50 rotate-12"
                                x-transition:enter-end="opacity-100 translate-x-0 scale-100 rotate-0"
                                x-transition:leave="transition-all duration-300 ease-in"
                                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-x-full scale-50">

                                {{-- Active Indicator --}}
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-green-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center cursor-pointer hover:bg-red-500 hover:text-white text-red-500 transition-all duration-300 hover:scale-110 hover:rotate-12 hover:shadow-lg hover:shadow-red-500/40 active:scale-95"
                                        @click="removeFromCart(item.id)">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-gray-800 text-sm truncate w-36 group-hover:text-green-600 transition-colors" x-text="item.name"></p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <button @click="updateQty(item.id, -1)" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition-all duration-200 active:scale-75 hover:scale-110 shadow-sm">
                                                <i class="fas fa-minus font-bold text-xs"></i>
                                            </button>

                                            <input type="number"
                                                class="w-16 h-8 text-center text-sm font-black text-gray-800 bg-gray-50 border-2 border-transparent focus:border-green-400 focus:bg-white rounded-lg transition-all outline-none"
                                                :value="item.quantity"
                                                @change="setQty(item.id, $el.value)"
                                                min="1">

                                            <button @click="updateQty(item.id, 1)" class="w-8 h-8 rounded-xl bg-green-100 hover:bg-green-500 hover:text-white flex items-center justify-center text-green-600 transition-all duration-200 active:scale-75 hover:scale-110 shadow-sm hover:shadow-green-500/50">
                                                <i class="fas fa-plus font-bold text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-black text-gray-900 text-base block group-hover:scale-110 transition-transform origin-right duration-300" x-text="'Rp ' + formatPrice(item.subtotal)"></span>
                                    <span class="text-[10px] font-medium text-gray-400" x-text="'@ Rp ' + formatPrice(item.price)"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Cart Summary --}}
                    <div class="pt-4 border-t border-gray-100 space-y-3">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span x-text="'Rp ' + formatPrice(subtotal)"></span>
                        </div>
                        <div class="flex justify-between text-2xl font-extrabold text-gray-900 pt-3 border-t border-dashed border-gray-200">
                            <span>TOTAL</span>
                            <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent" x-text="'Rp ' + formatPrice(total)"></span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="space-y-3 pt-2">
                        <button @click="prepareCheckout()" :disabled="cartCount === 0"
                            class="group relative w-full py-4 rounded-2xl font-bold text-lg flex items-center justify-center gap-3 transition-all duration-300 overflow-hidden"
                            :class="cartCount === 0 ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-xl shadow-green-500/30 hover:shadow-green-500/50 hover:scale-[1.02]'">

                            {{-- Shine Effect --}}
                            <div class="absolute top-0 -inset-full h-full w-1/2 z-0 block transform -skew-x-12 bg-gradient-to-r from-transparent to-white opacity-20 group-hover:animate-shine"></div>

                            <div class="relative z-10 flex items-center gap-3">
                                <i class="fas fa-credit-card group-hover:animate-bounce"></i>
                                <span>PROSES PEMBAYARAN</span>
                            </div>
                        </button>

                        <button @click="clearCart()" :disabled="cartCount === 0"
                            class="w-full py-3 rounded-xl font-medium transition-all duration-300 group"
                            :class="cartCount === 0 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-red-50 text-red-600 hover:bg-red-500 hover:text-white'">
                            <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform"></i>
                            <span class="group-hover:tracking-widest transition-all">Batalkan Transaksi</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('modals')
{{-- Payment Modal --}}
<div id="paymentModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="relative glass-card rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden animate-slide-up flex flex-col max-h-[90vh]">
        {{-- Modal Header --}}
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 text-center text-white flex-shrink-0">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-check-circle text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold">Konfirmasi Pembayaran</h3>
        </div>

        {{-- Modal Body --}}
        <div class="p-6 space-y-4 overflow-y-auto max-h-[70vh] no-scrollbar">
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-600">No. Invoice</span>
                <span id="invoiceNumber" class="font-bold text-gray-900"></span>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-600">Tanggal</span>
                <span id="transactionDate" class="font-bold text-gray-900"></span>
            </div>
            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                <span class="text-gray-700 font-medium">Total Pembayaran</span>
                <span id="totalPayment" class="text-2xl font-extrabold text-green-600"></span>
            </div>

            <form id="confirmPaymentForm" action="{{ route('cashier.transaction.processPayment') }}" method="POST" class="space-y-3 pt-4">
                @csrf
                <input type="hidden" id="invoiceInput" name="invoice_number">
                <input type="hidden" id="totalInput" name="total_amount">
                <input type="hidden" id="cartInput" name="cart_data">
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                    <i class="fas fa-check mr-2"></i> Konfirmasi Pembayaran
                </button>
                <button type="button" id="cancelPayment" class="w-full py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-all duration-300">
                    Batal
                </button>
            </form>
        </div>
    </div>
</div>

@include('components.detail_obat')
@endpush

@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cashierApp', () => ({
            medicines: @json($allMedicines),
            cart: {},
            search: @json(request('search', '')),
            category: @json(request('category', 'all')),
            loading: false,

            init() {
                // Handle Cancel Button for Payment Modal
                const cancelBtn = document.getElementById('cancelPayment');
                if (cancelBtn) {
                    cancelBtn.addEventListener('click', () => {
                        const modal = document.getElementById('paymentModal');
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    });
                }

                const sessionSuccess = @json(session('success') ? true : false);

                if (sessionSuccess) {
                    localStorage.removeItem('pos_cart');
                    this.cart = {};
                } else {
                    const storedCart = localStorage.getItem('pos_cart');
                    if (storedCart) {
                        try {
                            this.cart = JSON.parse(storedCart);
                        } catch (e) {
                            console.error('Cart parse error', e);
                            this.cart = {};
                        }
                    } else {
                        const sessionCart = @json(session('cart', []));
                        if (Object.keys(sessionCart).length > 0) {
                            this.cart = sessionCart;
                        }
                    }
                }

                this.$watch('cart', (val) => {
                    localStorage.setItem('pos_cart', JSON.stringify(val));
                });
            },

            get filteredMedicines() {
                return this.medicines.filter(medicine => {
                    const matchesSearch = medicine.name.toLowerCase().includes(this.search.toLowerCase());
                    const matchesCategory = this.category === 'all' || medicine.category === this.category;
                    return matchesSearch && matchesCategory;
                });
            },

            get cartItems() {
                return Object.values(this.cart);
            },

            get cartCount() {
                return this.cartItems.length;
            },

            get subtotal() {
                return this.cartItems.reduce((sum, item) => sum + item.subtotal, 0);
            },

            get diskon() {
                return 0; // Logic diskon bisa ditambahkan di sini
            },

            get total() {
                return this.subtotal - this.diskon;
            },

            addToCart(medicine) {
                if (medicine.stock <= 0) {
                    showToast('error', 'Stok habis!');
                    return;
                }

                if (this.cart[medicine.id]) {
                    if (this.cart[medicine.id].quantity + 1 > medicine.stock) {
                        showToast('error', 'Stok tidak mencukupi!');
                        return;
                    }
                    this.cart[medicine.id].quantity++;
                    this.cart[medicine.id].subtotal = this.cart[medicine.id].price * this.cart[medicine.id].quantity;
                } else {
                    this.cart[medicine.id] = {
                        id: medicine.id,
                        name: medicine.name,
                        price: medicine.price,
                        quantity: 1,
                        subtotal: medicine.price
                    };
                }
                showToast('success', 'Berhasil ditambahkan!');
            },

            updateQty(id, change) {
                if (this.cart[id]) {
                    const medicine = this.medicines.find(m => m.id === id);
                    const newQty = this.cart[id].quantity + change;

                    if (newQty <= 0) {
                        this.removeFromCart(id);
                        return;
                    }

                    if (medicine && newQty > medicine.stock) {
                        showToast('error', 'Stok tidak mencukupi!');
                        return;
                    }

                    this.cart[id].quantity = newQty;
                    this.cart[id].subtotal = this.cart[id].price * newQty;
                }
            },

            setQty(id, value) {
                const qty = parseInt(value);
                if (isNaN(qty) || qty < 1) {
                    // Reset to 1 if invalid
                    this.cart[id].quantity = 1;
                    this.cart[id].subtotal = this.cart[id].price;
                    return;
                }

                if (this.cart[id]) {
                    const medicine = this.medicines.find(m => m.id === id);

                    if (medicine && qty > medicine.stock) {
                        showToast('error', `Stok hanya tersedia ${medicine.stock}!`);
                        this.cart[id].quantity = medicine.stock;
                        this.cart[id].subtotal = this.cart[id].price * medicine.stock;
                        return;
                    }

                    this.cart[id].quantity = qty;
                    this.cart[id].subtotal = this.cart[id].price * qty;
                }
            },

            removeFromCart(id) {
                if (confirm('Hapus item ini?')) {
                    delete this.cart[id];
                }
            },

            clearCart() {
                if (confirm('Kosongkan keranjang?')) {
                    this.cart = {};
                }
            },

            prepareCheckout() {
                if (this.cartCount === 0) return;

                const today = new Date();
                const dateStr = today.getFullYear().toString() +
                    (today.getMonth() + 1).toString().padStart(2, '0') +
                    today.getDate().toString().padStart(2, '0');
                const uniqueCode = today.getTime().toString().slice(-5);
                const invoiceNumber = 'INV-' + dateStr + '-' + uniqueCode;

                const formattedDate = today.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                document.getElementById('invoiceNumber').textContent = invoiceNumber;
                document.getElementById('transactionDate').textContent = formattedDate;
                document.getElementById('totalPayment').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(this.total);

                // Set hidden inputs
                document.getElementById('invoiceInput').value = invoiceNumber;
                document.getElementById('totalInput').value = this.total;
                document.getElementById('cartInput').value = JSON.stringify(this.cart);

                const paymentModal = document.getElementById('paymentModal');
                paymentModal.classList.remove('hidden');
                paymentModal.classList.add('flex');
            },

            formatPrice(price) {
                return new Intl.NumberFormat('id-ID').format(price);
            }
        }));
    });

    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `fixed top-24 right-4 z-[100] glass-card border-l-4 ${type === 'success' ? 'border-green-500' : 'border-red-500'} px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-slide-right transition-all duration-500`;
        toast.innerHTML = `
            <div class="w-12 h-12 bg-gradient-to-br ${type === 'success' ? 'from-green-500 to-emerald-600' : 'from-red-500 to-rose-600'} rounded-xl flex items-center justify-center text-white">
                <i class="fas ${type === 'success' ? 'fa-check' : 'fa-exclamation-triangle'}"></i>
            </div>
            <div>
                <p class="font-bold text-gray-800">${type === 'success' ? 'Berhasil!' : 'Error!'}</p>
                <p class="text-gray-600 text-sm">${message}</p>
            </div>
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100px)';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
</script>
@endpush