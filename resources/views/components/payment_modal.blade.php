{{-- Modal Pembayaran --}}
<div id="payment-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        {{-- Konten Modal --}}
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white p-6">

                {{-- Tombol Close --}}
                <div class="flex justify-end">
                    <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 border-b pb-2 mb-4" id="modal-title">
                    Detail Pembayaran
                </h3>

                {{-- INFORMASI INVOICE --}}
                <div class="mb-4 text-center border-b pb-4">
                    <p class="text-sm text-gray-500">No. Invoice:</p>
                    <p id="invoice-number-display" class="text-xl font-extrabold text-indigo-600">{{ $invoiceNumber }}</p>
                </div>

                {{-- RINGKASAN TRANSAKSI --}}
                <div id="payment-form">
                    <h4 class="text-lg font-semibold text-gray-700 mb-3">Ringkasan Item:</h4>
                    <div class="space-y-2 max-h-40 overflow-y-auto border-b pb-4 mb-4">
                        @foreach ($cartItems as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-700">{{ $item['name'] }} ({{ $item['quantity'] }}x)</span>
                            <span class="font-medium">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between text-xl font-bold text-gray-900 mb-4">
                        <span>TOTAL AKHIR:</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    {{-- FORM BAYAR --}}
                    {{-- PENTING: ACTION INI HARUS MENGARAH KE FUNGSI DI CONTROLLER YANG MEMPROSES SIMPAN DB & KURANGI STOK --}}
                    <form action="{{ route('cashier.transaction.complete') }}" method="POST" id="complete-transaction-form">
                        @csrf

                        {{-- Kirim semua data item keranjang via input hidden jika Anda menggunakan pendekatan ini --}}
                        {{-- Cara yang lebih baik adalah menggunakan Session di Controller, tapi ini untuk memastikan data terkirim --}}
                        <input type="hidden" name="cart_items" value="{{ json_encode($cartItems) }}">
                        <input type="hidden" name="total_amount" value="{{ $total }}">
                        <input type="hidden" name="invoice_number" value="{{ $invoiceNumber }}">
                        <input type="hidden" name="amount_paid" id="hidden_amount_paid">

                        <div class="mb-4">
                            <label for="amount_paid" class="block text-sm font-medium text-gray-700 mb-1">Uang Bayar (Rp):</label>
                            <input type="number" id="amount_paid" name="amount_paid_display"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-2xl font-bold text-center focus:ring-green-500 focus:border-green-500 transition"
                                placeholder="Masukkan jumlah uang bayar" required min="{{ $total }}">
                        </div>

                        <div class="flex justify-between text-2xl font-bold mt-4">
                            <span>Kembalian:</span>
                            <span id="change-display" class="text-green-600">Rp 0</span>
                        </div>

                        <div class="mt-6">
                            <button type="submit" id="confirm-payment-button" disabled
                                class="w-full bg-green-500 text-white py-3 rounded-lg text-lg font-semibold hover:bg-green-600 transition duration-150 cursor-not-allowed disabled:bg-green-300">
                                KONFIRMASI PEMBAYARAN
                            </button>
                        </div>
                    </form>
                </div>

                {{-- ANIMASI LOADING --}}
                <div id="loading-message" class="hidden flex-col items-center justify-center py-10">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-indigo-500 mb-4"></div>
                    <p class="text-xl font-semibold text-gray-700">Menunggu Pembeli Membayar...</p>
                    <p class="text-sm text-gray-500 mt-2">Memproses transaksi dan memperbarui stok setelah konfirmasi.</p>
                </div>

            </div>
        </div>
    </div>
</div>