@include('components.cart.confirmDelete')
{{-- MODAL KERANJANG SIMULASI --}}
<div x-show="showCart"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 backdrop-blur-sm backdrop-brightness-50 z-50 flex items-center justify-center p-4"
    x-cloak>

    <div @click.outside="showCart = false"
        class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-6 transform transition-all max-h-screen overflow-y-auto">

        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-2xl font-bold text-gray-800">Keranjang</h3>
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
                        <span class="text-xl font-bold text-gray-800">Total Harga</span>
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
                <p class="text-gray-500">Keranjang kosong. Silakan tambahkan obat.</p>
            </div>
        </template>
    </div>
</div>