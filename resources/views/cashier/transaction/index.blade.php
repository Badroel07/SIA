@extends('cashier.layouts.app')

@section('title', 'Transaksi Kasir ePharma')

@section('content')

{{-- ========================================================================= --}}
{{-- 1. LOGIKA PHP UNTUK SESSION DAN TOTAL HARGA --}}
{{-- ========================================================================= --}}
@php
// Ambil item dari Session, default array kosong jika belum ada
$cartItems = Session::get('cart', []);
$subtotal = 0;
$diskon = 0;

// Hitung Subtotal
foreach ($cartItems as $item) {
$subtotal += $item['subtotal'];
}

$total = $subtotal - $diskon;
@endphp

{{-- Tampilkan Notifikasi Flash (Success/Error) --}}
@if (session('success'))
<div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="font-bold">Success!</span> <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif
@if (session('error'))
<div id="flash-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="font-bold">Error!</span> <span class="block sm:inline">{{ session('error') }}</span>
</div>
@endif


<div class="min-h-screen bg-gray-50 p-4 lg:p-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- SISI KIRI: PRODUK & FILTER --}}
        <div class="lg:col-span-2 space-y-6">

            <h1 class="text-3xl font-extrabold text-gray-900">Transaksi Baru</h1>

            {{-- Form Pencarian dan Filter --}}
            <form action="{{ route('cashier.transaction.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-lg flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4"
                x-data="{
                    searchTimeout: null,
                    loading: false,
                    performSearch() {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            this.loading = true;
                            const formData = new FormData($el);
                            const params = new URLSearchParams(formData);
                            fetch('{{ route('cashier.transaction.index') }}?' + params.toString(), {
                                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                            })
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newResults = doc.querySelector('#medicine-grid-results');
                                const currentResults = document.querySelector('#medicine-grid-results');
                                if (newResults && currentResults) { currentResults.innerHTML = newResults.innerHTML; }
                                this.loading = false;
                            })
                            .catch(error => { console.error('Search error:', error); this.loading = false; });
                        }, 400);
                    }
                }">

                <div class="flex-grow">
                    <label for="search" class="sr-only">Cari Obat</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="search" name="search" placeholder="Cari nama obat, kode, atau bahan aktif..."
                            value="{{ request('search') }}" @input="performSearch()"
                            class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                    </div>
                </div>

                <div>
                    <label for="category" class="sr-only">Filter Kategori</label>
                    <select id="category" name="category" @change="performSearch()" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="all" {{ request('category') === 'all' ? 'selected' : '' }}>Semua Kategori</option>

                        @foreach ($existingCategories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 flex items-center justify-center">
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" x-show="loading" x-cloak>
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-show="!loading">Cari</span>
                </button>
            </form>

            {{-- Daftar Obat --}}
            <div id="medicine-grid-results">
                @if ($medicines->isEmpty())
                <div class="text-center py-10 bg-white rounded-xl shadow-md">
                    <p class="text-xl text-gray-500">Tidak ada obat ditemukan.</p>
                    <p class="text-sm text-gray-400 mt-2">Coba ganti kata kunci atau filter Anda.</p>
                </div>
                @else
                {{-- PERUBAHAN HANYA DI GRID INI --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

                    @foreach ($medicines as $medicine)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition duration-200 border-2 border-gray-100 hover:border-indigo-400 hover:shadow-lg">

                        {{-- KEMBALIKAN UKURAN GAMBAR KE ASLI --}}
                        @if($medicine->image)
                        <img class="h-24 w-full object-cover"
                            src="{{ Storage::disk('s3')->url($medicine->image) }}"
                            alt="{{ $medicine->name }}">
                        @else
                        <div class="h-24 w-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @endif

                        {{-- KEMBALIKAN PADDING DAN FONT KE ASLI --}}
                        <div class="p-3 text-center">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $medicine->name }}</p>
                            <p class="text-xs text-gray-500 mb-1">{{ ucfirst($medicine->category) }}</p>
                            <p class="text-lg font-bold text-green-600">
                                {{ 'Rp ' . number_format($medicine->price, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-400">Stok: {{ $medicine->stock }}</p>

                            {{-- Tombol Detail Obat --}}
                            <a onclick="openMedicineDetailModal({{ $medicine->id }})"
                                class="cursor-pointer inline-block mt-2 text-xs text-indigo-600 hover:text-indigo-800 font-medium underline">
                                Lihat Detail
                            </a>
                        </div>

                        {{-- Form Tambah Item --}}
                        <form action="{{ route('cashier.transaction.cartAdd') }}" method="POST" class="p-3 border-t border-gray-100">
                            @csrf
                            <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">

                            <div class="flex space-x-2 items-center">
                                <input type="number" name="quantity" min="1" max="{{ $medicine->stock }}" value="1"
                                    class="w-1/3 text-center text-sm border border-gray-300 rounded-lg py-1 px-1 focus:ring-indigo-500 focus:border-indigo-500"
                                    required>

                                <button type="submit"
                                    class="w-2/3 flex items-center justify-center bg-indigo-500 text-white text-sm font-medium py-1 rounded-lg shadow-md hover:bg-indigo-600 transition duration-150"
                                    @if ($medicine->stock == 0) disabled @endif>
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah
                                </button>
                            </div>
                            @if ($medicine->stock == 0)
                            <p class="text-xs text-red-500 mt-1">Stok Habis</p>
                            @endif
                        </form>
                    </div>
                    @endforeach

                </div>
                @endif

                <div class="flex justify-center mt-6">
                    {{ $medicines->links() }}
                </div>
            </div> {{-- Close medicine-grid-results --}}

        </div> {{-- Close left column (lg:col-span-2) --}}

        {{-- SISI KANAN: KERANJANG BELANJA --}}
        {{-- Membuat keranjang menjadi sticky di semua ukuran layar sehingga tidak terpengaruh scroll halaman --}}
        <div class="sticky top-32 z-30 self-start w-full">
            <div class="bg-white p-6 rounded-xl shadow-2xl space-y-4 w-full">

                <h2 class="text-xl font-bold text-gray-800 border-b pb-3">Keranjang Belanja</h2>

                {{-- Looping Item Keranjang dari Session --}}
                {{-- Batasi tinggi list item agar jika banyak item, area ini scroll internal saja --}}
                <div class="space-y-3 max-h-[60vh] overflow-y-auto" id="cart-items">
                    @if (empty($cartItems))
                    <div class="text-center py-4 text-gray-500">
                        <p>Keranjang kosong. Isi kuantitas dan klik "Tambah" di sebelah kiri.</p>
                    </div>
                    @else
                    @foreach ($cartItems as $item)
                    <div class="flex justify-between items-center text-sm border-b pb-2">
                        <div class="flex flex-col text-left">
                            <span class="font-medium text-gray-700">{{ $item['name'] }}</span>
                            <span class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                        </div>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    @endif
                </div>

                {{-- Ringkasan Total --}}
                <div class="pt-3 border-t border-gray-200 space-y-2">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Diskon (0%):</span>
                        <span>Rp {{ number_format($diskon, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-gray-900 mt-3">
                        <span>TOTAL:</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Tombol Pembayaran --}}
                <button @if (empty($cartItems)) disabled class="w-full bg-green-300 text-white text-lg font-semibold py-3 rounded-lg shadow-xl cursor-not-allowed" @else id="prosesPembayaranBtn" class="w-full bg-green-500 text-white text-lg font-semibold py-3 rounded-lg shadow-xl hover:bg-green-600 transition duration-150 focus:ring-4 focus:ring-green-400" @endif>
                    <svg class="h-6 w-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    PROSES PEMBAYARAN
                </button>

                {{-- Form Batalkan Transaksi (Reset Session) --}}
                <form action="{{ route('cashier.transaction.cartClear') }}" method="POST" id="form-batal-transaksi">
                    @csrf
                    <button type="submit"
                        @if (empty($cartItems)) disabled @endif
                        class="w-full text-sm py-2 rounded-lg transition duration-150 
                        @if (empty($cartItems)) 
                            bg-gray-200 text-gray-500 cursor-not-allowed
                        @else 
                            bg-red-500 text-white hover:bg-red-600
                        @endif"
                        onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Semua item di keranjang akan dihapus.');">
                        Batalkan Transaksi
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL RINGKASAN TRANSAKSI --}}
{{-- ========================================================================= --}}
{{-- Modal ini akan muncul ketika tombol "PROSES PEMBAYARAN" diklik --}}
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-center text-gray-900">Ringkasan Transaksi</h3>

            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">No. Invoice:</span>
                    <span id="invoiceNumber" class="font-bold text-gray-900"></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Tanggal:</span>
                    <span id="transactionDate" class="font-bold text-gray-900"></span>
                </div>
                <div class="flex justify-between pt-3 mt-3 border-t border-gray-200">
                    <span class="font-medium text-gray-700">Total Pembayaran:</span>
                    <span id="totalPayment" class="text-lg font-bold text-green-600"></span>
                </div>
            </div>

            {{-- Form untuk mengirim data ke backend --}}
            <form id="confirmPaymentForm" action="{{ route('cashier.transaction.processPayment') }}" method="POST" class="mt-6">
                @csrf
                <input type="hidden" id="invoiceInput" name="invoice_number">
                <input type="hidden" id="totalInput" name="total_amount">
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition">
                        Konfirmasi
                    </button>
                    <button type="button" id="cancelPayment" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.detail_obat')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flash-message');

        // Logika Notifikasi Hilang Otomatis
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.style.transition = 'opacity 0.5s ease-out';
                flashMessage.style.opacity = '0';
                setTimeout(() => {
                    flashMessage.remove();
                }, 500);
            }, 3000);
        }

        // =========================================================================
        // LOGIKA UNTUK MODAL PEMBAYARAN
        // =========================================================================
        const prosesPembayaranBtn = document.getElementById('prosesPembayaranBtn');
        const paymentModal = document.getElementById('paymentModal');
        const cancelPaymentBtn = document.getElementById('cancelPayment');

        // Event listener untuk tombol "PROSES PEMBAYARAN"
        if (prosesPembayaranBtn) {
            prosesPembayaranBtn.addEventListener('click', function() {
                // 1. Generate Nomor Invoice
                const today = new Date();
                const dateStr = today.getFullYear().toString() +
                    (today.getMonth() + 1).toString().padStart(2, '0') +
                    today.getDate().toString().padStart(2, '0');
                // Menggunakan timestamp untuk memastikan keunikan
                const uniqueCode = today.getTime().toString().slice(-5);
                const invoiceNumber = 'INV-' + dateStr + '-' + uniqueCode;

                // 2. Format Tanggal Transaksi
                const formattedDate = today.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // 3. Ambil Total Harga dari halaman
                const totalElement = document.querySelector('.flex.justify-between.text-xl.font-bold.text-gray-900.mt-3 span:last-child');
                const totalText = totalElement ? totalElement.textContent : 'Rp 0';

                // 4. Isi data ke dalam modal
                document.getElementById('invoiceNumber').textContent = invoiceNumber;
                document.getElementById('transactionDate').textContent = formattedDate;
                document.getElementById('totalPayment').textContent = totalText;

                // 5. Isi data ke input hidden untuk dikirim ke backend
                document.getElementById('invoiceInput').value = invoiceNumber;
                // Hapus semua karakter non-digit untuk total amount
                document.getElementById('totalInput').value = totalText.replace(/[^\d]/g, '');

                // 6. Tampilkan modal
                paymentModal.classList.remove('hidden');
                paymentModal.classList.add('flex');
            });
        }

        // Event listener untuk tombol "BATAL" pada modal
        if (cancelPaymentBtn) {
            cancelPaymentBtn.addEventListener('click', function() {
                paymentModal.classList.add('hidden');
                paymentModal.classList.remove('flex');
            });
        }
    });
</script>
@endpush