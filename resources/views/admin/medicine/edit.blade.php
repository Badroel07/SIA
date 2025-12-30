{{-- Modal Edit Obat - Ultra Modern --}}
<div id="medicineEditModal" class="hidden fixed inset-0 bg-gray-900/60  z-[60] flex items-center justify-center p-4 sm:p-6">

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

        .modal-animate {
            animation: modalSlideIn 0.4s ease-out forwards;
        }

        .input-modern {
            transition: all 0.3s ease;
        }

        .input-modern:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }
    </style>

    <div id="editModalContent"
        class="relative mx-auto w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl rounded-2xl bg-white overflow-hidden transform opacity-0 scale-95 transition-all duration-300 ease-out">

        {{-- Header dengan Gradient --}}
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 relative overflow-hidden flex-shrink-0">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-10 w-20 h-20 bg-white/10 rounded-full translate-y-1/2"></div>

            <div class="flex justify-between items-center relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20  rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Edit Data Obat</h3>
                        <p class="text-blue-100 text-sm" id="edit-modal-name">-</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditMedicineModal()" class="w-12 h-12 bg-white/20 hover:bg-white/30  rounded-xl flex items-center justify-center text-white transition-all duration-300 hover:rotate-90 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Form Content --}}
        <div class="p-6 sm:p-8 overflow-y-auto flex-1 no-scrollbar">
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Error Validasi --}}
                @if ($errors->any())
                <div class="flex items-center gap-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl">
                    <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="font-bold text-red-700">Terjadi Kesalahan:</p>
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                {{-- Section: Data Dasar --}}
                <div class="bg-gradient-to-br from-gray-50 to-blue-50/30 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-pills text-white text-sm"></i>
                        </div>
                        Informasi Dasar
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label for="edit-name" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-tag text-blue-500"></i> Nama Obat
                            </label>
                            <input type="text" name="name" id="edit-name" required
                                class="input-modern w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:outline-none">
                        </div>

                        <div class="space-y-2">
                            <label for="edit-category-select2" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-folder text-blue-500"></i> Kategori
                            </label>
                            <select name="category" id="edit-category-select2" class="w-full">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($existingCategories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="edit-price" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-money-bill text-green-500"></i> Harga (Rp)
                            </label>
                            <input type="number" name="price" id="edit-price" required min="0"
                                class="input-modern w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-boxes text-purple-500"></i> Stok Saat Ini
                            </label>
                            <input type="text" id="edit-current-stock" disabled
                                class="w-full px-4 py-3 bg-gray-100 rounded-xl border-2 border-gray-200 cursor-not-allowed font-bold text-gray-600">
                        </div>
                    </div>
                </div>

                {{-- Section: Penyesuaian Stok --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200" x-data="{ mode: 'adjust' }">
                    <h4 class="text-lg font-bold text-blue-800 mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-arrows-alt-v text-white text-sm"></i>
                            </div>
                            <span>Manajemen Stok</span>
                        </div>
                        
                        {{-- Toggle Switch --}}
                        <div class="bg-white rounded-lg p-1 flex shadow-sm border border-blue-100">
                            <button type="button" @click="mode = 'adjust'; document.getElementById('edit-stock-manual').value = ''" 
                                class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-300"
                                :class="mode === 'adjust' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50'">
                                Penyesuaian (+/-)
                            </button>
                            <button type="button" @click="mode = 'manual'; document.getElementById('edit-stock-adjustment').value = ''"
                                class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-300"
                                :class="mode === 'manual' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50'">
                                Set Stok Awal
                            </button>
                        </div>
                    </h4>

                    {{-- Mode: Adjustment --}}
                    <div x-show="mode === 'adjust'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <input type="number" name="stock_adjustment" id="edit-stock-adjustment"
                            placeholder="Contoh: +10 untuk menambah, -5 untuk mengurangi"
                            class="input-modern w-full px-4 py-3 bg-white rounded-xl border-2 border-blue-200 focus:border-blue-500 focus:outline-none">
                        <p class="text-xs text-blue-600 mt-2">Masukkan angka positif untuk menambah, atau negatif untuk mengurangi stok.</p>

                        <div id="stock-reason-container" class="mt-4 hidden p-4 bg-white rounded-xl border border-blue-200">
                            <label class="block text-sm font-bold text-blue-800 mb-3">Alasan Pengurangan Stok:</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input id="sold-reason" name="stock_reason" value="sold" type="radio" class="w-5 h-5 text-blue-600">
                                    <span class="text-gray-700 font-medium">Terjual</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input id="other-reason" name="stock_reason" value="other" type="radio" class="w-5 h-5 text-blue-600" checked>
                                    <span class="text-gray-700 font-medium">Lainnya (hilang, rusak, dll)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Mode: Manual Set --}}
                    <div x-show="mode === 'manual'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <input type="number" name="stock_manual" id="edit-stock-manual" min="0"
                            placeholder="Masukkan jumlah total stok yang benar"
                            class="input-modern w-full px-4 py-3 bg-white rounded-xl border-2 border-purple-200 focus:border-purple-500 focus:outline-none focus:ring-4 focus:ring-purple-500/10">
                        <p class="text-xs text-purple-600 mt-2">
                            <i class="fas fa-info-circle mr-1"></i> 
                            Nilai ini akan <strong>menimpa</strong> jumlah stok saat ini. Gunakan untuk koreksi stok awal.
                        </p>
                    </div>
                </div>

                {{-- Section: Gambar --}}
                <div class="bg-gradient-to-br from-gray-50 to-purple-50/30 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-white text-sm"></i>
                        </div>
                        Gambar Produk
                    </h4>

                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl overflow-hidden shadow-inner flex items-center justify-center">
                                <img id="edit-current-image" src="" alt="" class="w-full h-full object-cover hidden">
                                <span id="edit-no-image" class="text-gray-400"><i class="fas fa-image text-3xl"></i></span>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <label for="edit-image" class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" id="edit-image"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                    </div>
                </div>

                {{-- Section: Detail Informasi --}}
                <div class="bg-gradient-to-br from-gray-50 to-green-50/30 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-white text-sm"></i>
                        </div>
                        Detail Informasi Obat
                    </h4>

                    <div class="space-y-5">
                        @php
                        $detailFields = [
                        'description' => ['label' => 'Deskripsi Singkat', 'rows' => 2, 'icon' => 'info-circle', 'color' => 'blue'],
                        'full_indication' => ['label' => 'Indikasi dan Manfaat', 'rows' => 3, 'icon' => 'check-circle', 'color' => 'green'],
                        'usage_detail' => ['label' => 'Cara Penggunaan / Dosis', 'rows' => 3, 'icon' => 'pills', 'color' => 'purple'],
                        'side_effects' => ['label' => 'Efek Samping', 'rows' => 3, 'icon' => 'exclamation-triangle', 'color' => 'amber'],
                        'contraindications' => ['label' => 'Kontraindikasi', 'rows' => 3, 'icon' => 'ban', 'color' => 'red']
                        ];
                        @endphp

                        @foreach($detailFields as $name => $data)
                        <div class="space-y-2">
                            <label for="edit-{{ $name }}" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-{{ $data['icon'] }} text-{{ $data['color'] }}-500"></i>
                                {{ $data['label'] }}
                            </label>
                            <textarea name="{{ $name }}" id="edit-{{ $name }}" rows="{{ $data['rows'] }}" required
                                class="input-modern w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:outline-none resize-none"></textarea>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditMedicineModal()"
                        class="flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all duration-300">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" id="editMedicineSubmit"
                        class="flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-[1.02] transition-all duration-300">
                        <i class="fas fa-save" id="editBtnIcon"></i>
                        <span id="editBtnText">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const baseUrl = "{{ url('/') }}";

    // AJAX Form Submission for Edit
    document.addEventListener('DOMContentLoaded', function() {
        const editForm = document.getElementById('editForm');

        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = document.getElementById('editMedicineSubmit');
            const btnIcon = document.getElementById('editBtnIcon');
            const btnText = document.getElementById('editBtnText');

            // Show loading state
            submitBtn.disabled = true;
            btnIcon.className = 'fas fa-spinner fa-spin';
            btnText.textContent = 'Menyimpan...';

            // Remove previous error messages
            const existingError = form.querySelector('.ajax-error-container');
            if (existingError) existingError.remove();

            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json().then(data => ({
                    status: response.status,
                    body: data
                })))
                .then(({
                    status,
                    body
                }) => {
                    if (status === 200 && body.success) {
                        // Success - close modal and refresh table
                        closeEditMedicineModal();
                        showNotification('success', body.message);
                        refreshMedicineTable();
                    } else if (status === 422) {
                        // Validation errors
                        let errorHtml = '<div class="ajax-error-container flex items-center gap-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl mb-4">';
                        errorHtml += '<div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-white flex-shrink-0"><i class="fas fa-exclamation-triangle"></i></div>';
                        errorHtml += '<div><p class="font-bold text-red-700">Terjadi Kesalahan:</p><ul class="list-disc list-inside text-sm text-red-600">';

                        if (body.errors) {
                            Object.values(body.errors).forEach(errors => {
                                errors.forEach(error => {
                                    errorHtml += `<li>${error}</li>`;
                                });
                            });
                        } else if (body.message) {
                            errorHtml += `<li>${body.message}</li>`;
                        }

                        errorHtml += '</ul></div></div>';
                        form.insertAdjacentHTML('afterbegin', errorHtml);
                        form.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Terjadi kesalahan. Silakan coba lagi.');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    btnIcon.className = 'fas fa-save';
                    btnText.textContent = 'Simpan Perubahan';
                });
        });

        // Stock adjustment visibility
        const stockAdjustmentInput = document.getElementById('edit-stock-adjustment');
        const stockReasonContainer = document.getElementById('stock-reason-container');

        stockAdjustmentInput?.addEventListener('input', function() {
            const value = parseInt(this.value);
            if (isNaN(value) || value >= 0) {
                stockReasonContainer.classList.add('hidden');
            } else {
                stockReasonContainer.classList.remove('hidden');
            }
        });
    });

    function initEditSelect2(currentCategory) {
        const select = $('#edit-category-select2');
        if (select.data('select2')) {
            select.select2('destroy');
        }

        const categoryToSelect = currentCategory || '';
        const isExisting = select.find('option[value="' + categoryToSelect + '"]').length > 0;

        if (!isExisting && categoryToSelect) {
            const newOption = new Option(categoryToSelect, categoryToSelect, true, true);
            select.append(newOption);
        }

        select.select2({
            placeholder: "Pilih atau ketik kategori baru...",
            dropdownParent: $('#medicineEditModal'),
            allowClear: true,
            tags: true,
        });

        select.val(categoryToSelect).trigger('change');
    }

    function openMedicineEditModal(id) {
        const modal = document.getElementById('medicineEditModal');
        const modalContent = document.getElementById('editModalContent');
        const form = document.getElementById('editForm');

        form.reset();
        document.getElementById('edit-stock-adjustment').value = '';
        if(document.getElementById('edit-stock-manual')) document.getElementById('edit-stock-manual').value = '';

        // Remove any previous error containers
        const existingError = form.querySelector('.ajax-error-container');
        if (existingError) existingError.remove();

        $.getJSON(baseUrl + '/admin/medicines/' + id + '/detail', function(data) {
            form.action = baseUrl + '/admin/medicines/' + id;

            document.getElementById('edit-modal-name').textContent = data.name;
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-price').value = data.price;
            document.getElementById('edit-current-stock').value = data.stock + ' unit';

            document.getElementById('edit-description').value = data.description || '';
            document.getElementById('edit-full_indication').value = data.full_indication || '';
            document.getElementById('edit-usage_detail').value = data.usage_detail || '';
            document.getElementById('edit-side_effects').value = data.side_effects || '';
            document.getElementById('edit-contraindications').value = data.contraindications || '';

            const img = document.getElementById('edit-current-image');
            const noImgSpan = document.getElementById('edit-no-image');

            if (data.image) {
                img.src = data.image_url || data.image;
                img.classList.remove('hidden');
                noImgSpan.classList.add('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                noImgSpan.classList.remove('hidden');
            }

            initEditSelect2(data.category);

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        });
    }

    function closeEditMedicineModal() {
        const modal = document.getElementById('medicineEditModal');
        const modalContent = document.getElementById('editModalContent');

        modalContent.classList.remove('opacity-100', 'scale-100');
        modalContent.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
</script>