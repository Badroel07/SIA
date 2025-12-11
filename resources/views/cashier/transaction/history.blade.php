{{-- resources/views/cashier/transaction/history.blade.php --}}
@extends('cashier.layouts.app')

@section('title', 'Riwayat Transaksi Kasir ePharma')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900">Riwayat Transaksi</h1>

                <!-- Form Pencarian -->
                <form action="{{ route('cashier.transaction.history') }}" method="GET" class="mt-4 sm:mt-0 w-full sm:w-auto"
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
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari No. Invoice..." value="{{ request('search') }}" @input="performSearch()"
                            class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                    </div>
                </form>
            </div>

            <!-- Tabel Riwayat Transaksi -->
            <div id="history-table-results">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Invoice</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->invoice_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ date('d M Y H:i', strtotime($transaction->transaction_date)) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->user ? $transaction->user->name : 'Pengguna Dihapus' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if ($transaction->status == 'completed') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="showTransactionDetail({{ $transaction->id }})" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada riwayat transaksi ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">{{ $transactions->links() }}</div>
            </div> {{-- Close history-table-results --}}
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL DETAIL TRANSAKSI --}}
    {{-- ========================================================================= --}}
    <div id="transactionDetailModal" class="fixed inset-0 backdrop-blur-sm backdrop-brightness-50 hidden items-center justify-center z-50">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b p-6 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Detail Transaksi</h3>
                <button onclick="closeTransactionDetail()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <!-- Info Header Transaksi -->
                <div class="mb-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="font-medium text-gray-700">No. Invoice:</span><span id="detail-invoice" class="font-bold text-gray-900"></span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-700">Tanggal:</span><span id="detail-date" class="font-bold text-gray-900"></span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-700">Kasir:</span><span id="detail-cashier" class="font-bold text-gray-900"></span></div>
                </div>
                <!-- Tabel Detail Item -->
                <div class="overflow-x-auto mb-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Obat</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="detail-items" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
                <!-- Total -->
                <div class="border-t pt-4 text-right">
                    <span class="text-lg font-bold text-gray-900">Total: <span id="detail-total"></span></span>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('scripts')
    <script>
        function showTransactionDetail(transactionId) {
            const modal = document.getElementById('transactionDetailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('detail-invoice').textContent = 'Memuat...';
            document.getElementById('detail-date').textContent = '';
            document.getElementById('detail-cashier').textContent = '';
            document.getElementById('detail-items').innerHTML = '<tr><td colspan="4" class="text-center py-4">Memuat data...</td></tr>';
            document.getElementById('detail-total').textContent = '';

            fetch(`/cashier/transaction/${transactionId}/details`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data dari server. Status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data || data.error) {
                        throw new Error(data.error || 'Data transaksi tidak ditemukan.');
                    }

                    document.getElementById('detail-invoice').textContent = data.invoice_number;
                    document.getElementById('detail-date').textContent = new Date(data.transaction_date).toLocaleString('id-ID');
                    document.getElementById('detail-cashier').textContent = data.user ? data.user.name : 'Pengguna Dihapus';

                    let itemsHtml = '';
                    if (data.details && data.details.length > 0) {
                        data.details.forEach(item => {
                            if (item.medicine) {
                                itemsHtml += `
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900">${item.medicine.name}</td>
                                <td class="px-4 py-2 text-sm text-center text-gray-900">${item.quantity}</td>
                                <td class="px-4 py-2 text-sm text-right text-gray-900">Rp ${formatRupiah(item.price)}</td>
                                <td class="px-4 py-2 text-sm text-right font-medium text-gray-900">Rp ${formatRupiah(item.subtotal)}</td>
                            </tr>
                        `;
                            } else {
                                itemsHtml += `
                            <tr>
                                <td class="px-4 py-2 text-sm text-red-600 italic">Obat telah dihapus (ID: ${item.medicine_id})</td>
                                <td class="px-4 py-2 text-sm text-center text-gray-900">${item.quantity}</td>
                                <td class="px-4 py-2 text-sm text-right text-gray-900">Rp ${formatRupiah(item.price)}</td>
                                <td class="px-4 py-2 text-sm text-right font-medium text-gray-900">Rp ${formatRupiah(item.subtotal)}</td>
                            </tr>
                        `;
                            }
                        });
                    } else {
                        itemsHtml = '<tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada detail item.</td></tr>';
                    }

                    document.getElementById('detail-items').innerHTML = itemsHtml;
                    document.getElementById('detail-total').textContent = 'Rp ' + formatRupiah(data.total_amount);
                })
                .catch(error => {
                    console.error('Error fetching transaction details:', error);
                    document.getElementById('detail-items').innerHTML = `<tr><td colspan="4" class="text-center py-4 text-red-500">${error.message}</td></tr>`;
                });
        }

        function closeTransactionDetail() {
            const modal = document.getElementById('transactionDetailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        /**
         * Fungsi helper untuk memformat angka menjadi format Rupiah
         * Menggantikan fungsi number_format dari PHP
         */
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
    </script>
    @endpush