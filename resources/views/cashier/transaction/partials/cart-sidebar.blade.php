<div id="cart-content">
    {{-- Cart Header --}}
    <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
            <i class="fas fa-shopping-cart text-xl"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Keranjang</h2>
            <p class="text-sm text-gray-500">{{ count($cartItems) }} item</p>
        </div>
    </div>

    {{-- Cart Items --}}
    <div class="space-y-3 max-h-[45vh] overflow-y-auto no-scrollbar" id="cart-items">
        @if (empty($cartItems))
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-shopping-basket text-2xl text-gray-400"></i>
            </div>
            <p class="text-gray-500 font-medium">Keranjang kosong</p>
            <p class="text-gray-400 text-sm">Tambahkan produk dari katalog</p>
        </div>
        @else
        @foreach ($cartItems as $item)
        <div class="group flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-indigo-200 hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-pills text-green-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">{{ $item['name'] }}</p>
                    <p class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                </div>
            </div>
            <span class="font-bold text-gray-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
        </div>
        @endforeach
        @endif
    </div>

    {{-- Cart Summary --}}
    <div class="pt-4 border-t border-gray-100 space-y-3">
        <div class="flex justify-between text-sm text-gray-600">
            <span>Subtotal</span>
            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-600">
            <span>Diskon</span>
            <span class="text-green-600">- Rp {{ number_format($diskon ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-2xl font-extrabold text-gray-900 pt-3 border-t border-dashed border-gray-200">
            <span>TOTAL</span>
            <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="space-y-3 pt-2">
        <button @if(empty($cartItems)) disabled @endif id="prosesPembayaranBtn"
            class="group w-full py-4 rounded-2xl font-bold text-lg flex items-center justify-center gap-3 transition-all duration-300
            {{ empty($cartItems) ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-xl shadow-green-500/30 hover:shadow-green-500/50 hover:scale-[1.02]' }}">
            <i class="fas fa-credit-card group-hover:animate-pulse"></i>
            PROSES PEMBAYARAN
        </button>

        <form action="{{ route('cashier.transaction.cartClear') }}" method="POST" id="form-batal-transaksi">
            @csrf
            <button type="submit" @if(empty($cartItems)) disabled @endif
                onclick="return confirm('Yakin ingin membatalkan transaksi?');"
                class="w-full py-3 rounded-xl font-medium transition-all duration-300
                {{ empty($cartItems) ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-red-50 text-red-600 hover:bg-red-500 hover:text-white' }}">
                <i class="fas fa-times mr-2"></i> Batalkan Transaksi
            </button>
        </form>
    </div>
</div>