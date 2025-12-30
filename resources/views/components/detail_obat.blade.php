{{-- Modal Detail Obat - Ultra Modern --}}
<div id="medicineDetailModal" class="hidden fixed inset-0 bg-gray-900/60  z-[60] flex items-center justify-center p-4 sm:p-6">

    <style>
        @keyframes modalSlideIn {
            0% {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .modal-animate {
            animation: modalSlideIn 0.4s ease-out forwards;
        }

        .shimmer-loading {
            animation: shimmer 1.5s infinite;
            background: linear-gradient(90deg, #f3f4f6, #e5e7eb, #f3f4f6);
            background-size: 200% 100%;
        }
    </style>

    <div class="relative mx-auto p-0 w-full max-w-4xl shadow-2xl rounded-3xl bg-white overflow-hidden modal-animate" style="max-height: 90vh;">

        {{-- Header Modal dengan Gradient --}}
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 relative overflow-hidden">
            {{-- Decorative --}}
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-10 w-20 h-20 bg-white/10 rounded-full translate-y-1/2"></div>

            <div class="flex justify-between items-center relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20  rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-pills text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Detail Obat</h3>
                        <p class="text-blue-100 text-sm">Informasi lengkap produk</p>
                    </div>
                </div>
                <button onclick="closeMedicineDetailModal()" class="w-12 h-12 bg-white/20 hover:bg-white/30  rounded-xl flex items-center justify-center text-white transition-all duration-300 hover:rotate-90 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Content akan diisi dengan JavaScript --}}
        <div id="medicineDetailContent" class="p-6 space-y-6 overflow-y-auto" style="max-height: calc(90vh - 100px);">
            {{-- Loading State --}}
            <div class="flex flex-col justify-center items-center py-16">
                <div class="relative">
                    <div class="w-16 h-16 border-4 border-blue-200 rounded-full"></div>
                    <div class="w-16 h-16 border-4 border-blue-600 rounded-full border-t-transparent animate-spin absolute top-0 left-0"></div>
                </div>
                <p class="text-gray-500 mt-4 font-medium">Memuat data...</p>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript untuk kontrol modal --}}
<script>
    function openMedicineDetailModal(medicineId) {
        const modal = document.getElementById('medicineDetailModal');
        const content = document.getElementById('medicineDetailContent');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Show loading
        content.innerHTML = `
            <div class="flex flex-col justify-center items-center py-16">
                <div class="relative">
                    <div class="w-16 h-16 border-4 border-blue-200 rounded-full"></div>
                    <div class="w-16 h-16 border-4 border-blue-600 rounded-full border-t-transparent animate-spin absolute top-0 left-0"></div>
                </div>
                <p class="text-gray-500 mt-4 font-medium">Memuat data...</p>
            </div>
        `;

        // Try URL 1 first, then URL 2
        fetch(`/admin/medicines/${medicineId}/detail`)
            .then(response => {
                if (!response.ok) throw new Error('URL 1 gagal');
                return response.json();
            })
            .then(data => {
                content.innerHTML = generateDetailHTML(data);
            })
            .catch(error => {
                console.log('URL 1 gagal, mencoba URL 2...', error);
                return fetch(`/cashier/transaction/medicines/${medicineId}/detail`)
                    .then(response => response.json())
                    .then(data => {
                        content.innerHTML = generateDetailHTML(data);
                    });
            })
            .catch(error => {
                content.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16">
                        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
                        </div>
                        <p class="text-red-600 font-bold text-lg">Gagal memuat data!</p>
                        <p class="text-gray-500 text-sm mt-2">Silakan coba lagi nanti</p>
                    </div>
                `;
            });
    }

    function generateDetailHTML(medicine) {
        return `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column: Image & Basic Info -->
                <div class="md:col-span-1 space-y-4">
                    <div class="relative bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 text-center border border-blue-100">
                        ${medicine.image 
                            ? `<img src="${medicine.image}" alt="${medicine.name}" class="w-full h-48 object-contain rounded-xl mb-4 shadow-lg">`
                            : `<div class="w-full h-48 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center mb-4">
                                <i class="fas fa-capsules text-5xl text-blue-400"></i>
                               </div>`
                        }
                        <h4 class="text-xl font-bold text-gray-800">${medicine.name}</h4>
                        <span class="inline-flex items-center gap-1 mt-2 px-4 py-1.5 text-sm font-bold rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg">
                            <i class="fas fa-tag"></i>
                            ${medicine.category}
                        </span>
                    </div>

                    <!-- Price & Stock Card -->
                    <div class="bg-white rounded-2xl p-5 space-y-4 border border-gray-100 shadow-lg">
                        <div class="flex justify-between items-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl">
                            <span class="text-sm text-gray-600 font-medium">Harga</span>
                            <span class="text-xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                Rp ${new Intl.NumberFormat('id-ID').format(medicine.price)}
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm text-gray-600 font-medium">Stok</span>
                            <span class="px-3 py-1 text-sm font-bold rounded-lg ${medicine.stock > 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                                ${medicine.stock} unit
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm text-gray-600 font-medium">Terjual</span>
                            <span class="px-3 py-1 text-sm font-bold rounded-lg bg-purple-100 text-purple-700">
                                ${medicine.total_sold || 0} unit
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details -->
                <div class="md:col-span-2 space-y-4">
                    <!-- Description -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
                        <h5 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-info-circle text-white text-sm"></i>
                            </div>
                            Deskripsi
                        </h5>
                        <p class="text-gray-700 leading-relaxed">${medicine.description || '-'}</p>
                    </div>

                    <!-- Indication -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-5 border border-green-100">
                        <h5 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                            </div>
                            Indikasi dan Manfaat
                        </h5>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">${medicine.full_indication || '-'}</p>
                    </div>

                    <!-- Usage -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-5 border border-purple-100">
                        <h5 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pills text-white text-sm"></i>
                            </div>
                            Cara Penggunaan / Dosis
                        </h5>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">${medicine.usage_detail || '-'}</p>
                    </div>

                    <!-- Side Effects -->
                    <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl p-5 border border-amber-100">
                        <h5 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                            </div>
                            Efek Samping
                        </h5>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">${medicine.side_effects || '-'}</p>
                    </div>

                    <!-- Contraindications -->
                    <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-2xl p-5 border border-red-100">
                        <h5 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-ban text-white text-sm"></i>
                            </div>
                            Larangan / Kontraindikasi
                        </h5>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">${medicine.contraindications || '-'}</p>
                    </div>
                </div>
            </div>
        `;
    }

    function closeMedicineDetailModal() {
        document.getElementById('medicineDetailModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal with ESC key only (removed click outside to close)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMedicineDetailModal();
        }
    });
</script>