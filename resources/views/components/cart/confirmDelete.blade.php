{{-- MODAL KONFIRMASI KOSONGKAN KERANJANG --}}
<div x-show="showConfirmClear"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 backdrop-blur-sm backdrop-brightness-50 z-50 flex items-center justify-center p-4"
    x-cloak>

    <div @click.outside="showConfirmClear = false"
        class="bg-white w-full max-w-sm rounded-xl shadow-2xl p-6 transform transition-all">

        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center text-red-500">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c.866 0 1.34-1.01.789-1.637L12.789 4.363c-.45-.63-.17-1.637.789-1.637z"></path>
            </svg>
            Konfirmasi
        </h3>

        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin mengosongkan seluruh keranjang ini?</p>

        <div class="flex justify-end gap-3">
            <button @click="showConfirmClear = false" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                Batal
            </button>
            <button @click="clearCartConfirmed()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition">
                Ya, Kosongkan
            </button>
        </div>
    </div>
</div>