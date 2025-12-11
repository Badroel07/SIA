{{-- FLOATING CART SIMULASI --}}
<div class="fixed bottom-20 right-4 z-[60]">
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