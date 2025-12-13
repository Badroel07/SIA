@include('components.cart.confirmDelete')

{{-- MODAL KERANJANG - Ultra Modern --}}
<div x-show="showCart"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[70] flex items-center justify-center p-4"
    style="background-color: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
    x-cloak>

    <div @click.outside="showCart = false"
        class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden transform transition-all">

        {{-- Header dengan Gradient --}}
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>

            <div class="flex justify-between items-center relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Keranjang Belanja</h3>
                        <p class="text-indigo-100 text-sm" x-text="cart.length + ' item'"></p>
                    </div>
                </div>
                <button @click="showCart = false" class="w-10 h-10 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl flex items-center justify-center text-white transition-all duration-300 hover:rotate-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <template x-if="cart.length > 0">
                <div>
                    {{-- Item List --}}
                    <ul class="space-y-3 max-h-80 overflow-y-auto pr-2 no-scrollbar">
                        <template x-for="item in cart" :key="item.id">
                            <li class="flex justify-between items-center p-3 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-indigo-200 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.761 2.156 18 5.414 18H14.586c3.258 0 4.597-3.239 2.707-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.47-.156a4 4 0 00-2.172-.102l1.027-1.028A3 3 0 009 8.172z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800" x-text="item.name"></p>
                                        <p class="text-sm text-gray-500">
                                            Rp <span x-text="item.price.toLocaleString('id-ID')"></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    {{-- Quantity Controls --}}
                                    <div class="flex items-center gap-1 bg-gray-100 rounded-xl p-1">
                                        <button @click="updateQty(item.id, -1)" class="w-8 h-8 rounded-lg bg-white shadow-sm text-gray-600 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center font-bold">-</button>
                                        <span x-text="item.qty" class="w-8 text-center font-bold text-gray-800"></span>
                                        <button @click="updateQty(item.id, 1)" class="w-8 h-8 rounded-lg bg-white shadow-sm text-gray-600 hover:bg-green-500 hover:text-white transition-all flex items-center justify-center font-bold">+</button>
                                    </div>
                                    {{-- Subtotal --}}
                                    <span class="font-bold text-indigo-600 min-w-[100px] text-right" x-text="`Rp ${(item.price * item.qty).toLocaleString('id-ID')}`"></span>
                                </div>
                            </li>
                        </template>
                    </ul>

                    {{-- Footer --}}
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        {{-- Total --}}
                        <div class="flex justify-between items-center p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl mb-4">
                            <span class="text-lg font-bold text-gray-700">Total Harga</span>
                            <span class="text-2xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent" x-text="`Rp ${cartTotal.toLocaleString('id-ID')}`"></span>
                        </div>

                        {{-- Clear Button --}}
                        <button @click="confirmClear()" class="w-full py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Kosongkan Keranjang
                        </button>
                    </div>
                </div>
            </template>

            {{-- Empty State --}}
            <template x-if="cart.length === 0">
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 font-bold text-lg">Keranjang Kosong</p>
                    <p class="text-gray-400 text-sm mt-1">Silakan tambahkan obat ke keranjang</p>
                </div>
            </template>
        </div>
    </div>
</div>