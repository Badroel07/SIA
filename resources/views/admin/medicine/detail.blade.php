{{-- Modal Detail Obat --}}
<div id="medicineDetailModal" class="hidden fixed inset-0 backdrop-blur-sm backdrop-brightness-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 w-full max-w-4xl shadow-lg rounded-xl bg-white mb-10">
        {{-- Header Modal --}}
        <div class="flex justify-between items-center border-b pb-3 mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Detail Informasi Obat</h3>
            <button onclick="closeMedicineDetailModal()" class="text-gray-400 hover:text-gray-600 text-3xl font-bold">&times;</button>
        </div>

        {{-- Content akan diisi dengan JavaScript --}}
        <div id="medicineDetailContent" class="space-y-6">
            {{-- Loading State --}}
            <div class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
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
            <div class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
        `;

        // Fetch detail data via AJAX
        fetch(`/admin/medicines/${medicineId}/detail`)
            .then(response => response.json())
            .then(data => {
                content.innerHTML = generateDetailHTML(data);
            })
            .catch(error => {
                content.innerHTML = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <p class="font-bold">Error memuat data!</p>
                        <p class="text-sm">${error.message}</p>
                    </div>
                `;
            });
    }

    function generateDetailHTML(medicine) {
        return `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Kolom Kiri: Gambar & Info Dasar --}}
                <div class="md:col-span-1 space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        ${medicine.image 
                            ? `<img src="/storage/${medicine.image}" alt="${medicine.name}" class="w-full h-48 object-contain rounded-lg mb-4">`
                            : `<div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-capsules text-6xl text-gray-400"></i>
                               </div>`
                        }
                        <h4 class="text-xl font-bold text-gray-800">${medicine.name}</h4>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            ${medicine.category}
                        </span>
                    </div>

                    {{-- Info Stok & Harga --}}
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Harga</span>
                            <span class="text-lg font-bold text-green-600">Rp ${new Intl.NumberFormat('id-ID').format(medicine.price)}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Stok Tersedia</span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full ${medicine.stock > 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${medicine.stock} unit
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Terjual</span>
                            <span class="text-sm font-semibold text-gray-800">${medicine.total_sold || 0} unit</span>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Detail Lengkap --}}
                <div class="md:col-span-2 space-y-4">
                    {{-- Deskripsi Singkat --}}
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h5 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-600"></i>
                            Deskripsi
                        </h5>
                        <p class="text-sm text-gray-700">${medicine.description || '-'}</p>
                    </div>

                    {{-- Indikasi & Manfaat --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            Indikasi dan Manfaat
                        </h5>
                        <p class="text-sm text-gray-700 whitespace-pre-line">${medicine.full_indication || '-'}</p>
                    </div>

                    {{-- Cara Penggunaan --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-pills text-purple-600"></i>
                            Cara Penggunaan / Dosis
                        </h5>
                        <p class="text-sm text-gray-700 whitespace-pre-line">${medicine.usage_detail || '-'}</p>
                    </div>

                    {{-- Efek Samping --}}
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <h5 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                            Efek Samping
                        </h5>
                        <p class="text-sm text-gray-700 whitespace-pre-line">${medicine.side_effects || '-'}</p>
                    </div>

                    {{-- Kontraindikasi --}}
                    <div class="bg-red-50 rounded-lg p-4">
                        <h5 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-ban text-red-600"></i>
                            Larangan / Kontraindikasi
                        </h5>
                        <p class="text-sm text-gray-700 whitespace-pre-line">${medicine.contraindications || '-'}</p>
                    </div>
                </div>
            </div>
        `;
    }

    function closeMedicineDetailModal() {
        document.getElementById('medicineDetailModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('medicineDetailModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeMedicineDetailModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMedicineDetailModal();
        }
    });
</script>