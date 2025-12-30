{{-- resources/views/cashier/transaction/history.blade.php --}}
@extends('cashier.layouts.app')

@section('title', 'Riwayat Transaksi Kasir ePharma')

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

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-8px);
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

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.15);
    }

    .table-row-hover {
        transition: all 0.2s ease;
    }

    .table-row-hover:hover {
        background: linear-gradient(90deg, rgba(16, 185, 129, 0.05), transparent);
        transform: scale(1.002);
    }
</style>

<div class="min-h-screen p-4 lg:p-8">

    <!-- Background Decorations -->
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-green-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header Card --}}
        <div class="glass-card p-6 rounded-3xl shadow-xl border border-gray-100 animate-slide-up">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-500/30">
                        <i class="fas fa-history text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
                        <p class="text-gray-500">Lihat semua transaksi yang telah dilakukan</p>
                    </div>
                </div>

                {{-- Search Form --}}
                <form action="{{ route('cashier.transaction.history') }}" method="GET" class="w-full md:w-auto"
                    x-data="{
                        searchTimeout: null,
                        loading: false,
                        performSearch() {
                            clearTimeout(this.searchTimeout);
                            this.searchTimeout = setTimeout(() => {
                                this.loading = true;
                                const formData = new FormData($el);
                                const params = new URLSearchParams(formData);
                                fetch('{{ route('cashier.transaction.history') }}?' + params.toString(), {
                                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newResults = doc.querySelector('#history-table-results');
                                    const currentResults = document.querySelector('#history-table-results');
                                    if (newResults && currentResults) { currentResults.innerHTML = newResults.innerHTML; }
                                    this.loading = false;
                                })
                                .catch(error => { console.error('Search error:', error); this.loading = false; });
                            }, 400);
                        }
                    }">
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-purple-50 group-focus-within:bg-purple-100 flex items-center justify-center transition-colors">
                            <svg class="h-5 w-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari No. Invoice..." value="{{ request('search') }}" @input="performSearch()"
                            class="w-full md:w-80 pl-16 pr-4 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 focus:bg-white">
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div id="history-table-results" class="glass-card rounded-3xl shadow-xl border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 0.1s;">
            <div class="overflow-x-auto no-scrollbar">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-purple-50/30">
                        <tr>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Invoice</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kasir</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transactions as $index => $transaction)
                        <tr class="table-row-hover bg-white" style="animation: slideInUp 0.4s ease-out {{ $index * 0.05 }}s forwards; opacity: 0;">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-receipt text-purple-600"></i>
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $transaction->invoice_number }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    {{ date('d M Y', strtotime($transaction->transaction_date)) }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-clock mr-1"></i>{{ date('H:i', strtotime($transaction->transaction_date)) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-bold text-green-600">{{ substr($transaction->user ? $transaction->user->name : 'X', 0, 1) }}</span>
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ $transaction->user ? $transaction->user->name : 'Pengguna Dihapus' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-lg font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-bold rounded-xl 
                                    @if ($transaction->status == 'completed') 
                                        bg-gradient-to-r from-green-100 to-emerald-100 text-green-700
                                    @else 
                                        bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-700
                                    @endif">
                                    @if ($transaction->status == 'completed')
                                    <i class="fas fa-check-circle text-xs"></i>
                                    @else
                                    <i class="fas fa-clock text-xs"></i>
                                    @endif
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="showTransactionDetail({{ $transaction->id }})"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-all duration-300 hover:scale-105">
                                    <i class="fas fa-eye"></i>
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                        <i class="fas fa-receipt text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-xl text-gray-600 font-bold mb-2">Belum Ada Transaksi</p>
                                    <p class="text-gray-400 mb-6">Tidak ada riwayat transaksi ditemukan</p>
                                    <a href="{{ route('cashier.transaction.index') }}"
                                        class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                        <i class="fas fa-plus"></i>
                                        Buat Transaksi Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($transactions->hasPages())
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-purple-50/30 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>

    @push('modals')
    {{-- Transaction Detail Modal --}}
    <div id="transactionDetailModal" class="fixed inset-0 bg-gray-900/60  hidden items-center justify-center z-50">
        <div class="relative glass-card rounded-3xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-hidden animate-slide-up">

            {{-- Modal Header --}}
            <div class="sticky top-0 bg-gradient-to-r from-purple-600 to-indigo-600 p-6 flex justify-between items-center text-white">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Detail Transaksi</h3>
                        <p class="text-purple-100 text-sm" id="detail-invoice">Memuat...</p>
                    </div>
                </div>
                <button onclick="closeTransactionDetail()" class="p-2 hover:bg-white/20 rounded-xl transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-100px)]">
                {{-- Transaction Info --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Tanggal</p>
                        <p id="detail-date" class="text-gray-900 font-bold">-</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Kasir</p>
                        <p id="detail-cashier" class="text-gray-900 font-bold">-</p>
                    </div>
                </div>

                {{-- Items Table --}}
                <div class="bg-gray-50 rounded-2xl overflow-hidden mb-6">
                    <div class="px-4 py-3 bg-gradient-to-r from-gray-100 to-gray-50 border-b border-gray-200">
                        <h4 class="font-bold text-gray-700">Daftar Item</h4>
                    </div>
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase">
                                <th class="px-4 py-3 text-left font-bold">Obat</th>
                                <th class="px-4 py-3 text-center font-bold">Qty</th>
                                <th class="px-4 py-3 text-right font-bold">Harga</th>
                                <th class="px-4 py-3 text-right font-bold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="detail-items" class="divide-y divide-gray-100 bg-white"></tbody>
                    </table>
                </div>

                {{-- Total --}}
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border-2 border-green-200">
                    <span class="text-gray-700 font-bold text-lg">Total Pembayaran</span>
                    <span id="detail-total" class="text-2xl font-extrabold text-green-600"></span>
                </div>
            </div>
        </div>
    </div>
    @endpush
</div>

@endsection

@push('scripts')
<script>
    function showTransactionDetail(transactionId) {
        const modal = document.getElementById('transactionDetailModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.getElementById('detail-invoice').textContent = 'Memuat...';
        document.getElementById('detail-date').textContent = '-';
        document.getElementById('detail-cashier').textContent = '-';
        document.getElementById('detail-items').innerHTML = '<tr><td colspan="4" class="text-center py-8 text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...</td></tr>';
        document.getElementById('detail-total').textContent = '';

        fetch(`/cashier/transaction/${transactionId}/details`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal mengambil data');
                return response.json();
            })
            .then(data => {
                if (!data || data.error) throw new Error(data.error || 'Data tidak ditemukan');

                document.getElementById('detail-invoice').textContent = data.invoice_number;
                document.getElementById('detail-date').textContent = new Date(data.transaction_date).toLocaleString('id-ID');
                document.getElementById('detail-cashier').textContent = data.user ? data.user.name : 'Pengguna Dihapus';

                let itemsHtml = '';
                if (data.details && data.details.length > 0) {
                    data.details.forEach(item => {
                        const name = item.medicine ? item.medicine.name : 'Obat telah dihapus';
                        const nameClass = item.medicine ? 'text-gray-900' : 'text-red-500 italic';
                        itemsHtml += `
                            <tr>
                                <td class="px-4 py-3 ${nameClass} font-medium">${name}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 bg-gray-100 rounded-lg font-bold text-gray-700">${item.quantity}</span>
                                </td>
                                <td class="px-4 py-3 text-right text-gray-600">Rp ${formatRupiah(item.price)}</td>
                                <td class="px-4 py-3 text-right font-bold text-gray-900">Rp ${formatRupiah(item.subtotal)}</td>
                            </tr>
                        `;
                    });
                } else {
                    itemsHtml = '<tr><td colspan="4" class="text-center py-8 text-gray-500">Tidak ada item</td></tr>';
                }

                document.getElementById('detail-items').innerHTML = itemsHtml;
                document.getElementById('detail-total').textContent = 'Rp ' + formatRupiah(data.total_amount);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('detail-items').innerHTML = `<tr><td colspan="4" class="text-center py-8 text-red-500"><i class="fas fa-exclamation-circle mr-2"></i>${error.message}</td></tr>`;
            });
    }

    function closeTransactionDetail() {
        const modal = document.getElementById('transactionDetailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
</script>
@endpush