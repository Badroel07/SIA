{{-- Modal Create Obat - Ultra Modern --}}
<div id="medicineModal" class="hidden fixed inset-0 bg-gray-900/60  z-[60] flex items-center justify-center p-4 sm:p-6">

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

        .modal-animate-create {
            animation: modalSlideIn 0.4s ease-out forwards;
        }

        .input-modern-create {
            transition: all 0.3s ease;
        }

        .input-modern-create:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }
    </style>

    <div id="modalContent"
        class="relative mx-auto w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl rounded-2xl bg-white overflow-hidden transform opacity-0 scale-95 transition-all duration-300 ease-out">

        {{-- Header dengan Gradient --}}
        <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-6 relative overflow-hidden flex-shrink-0">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-10 w-20 h-20 bg-white/10 rounded-full translate-y-1/2"></div>

            <div class="flex justify-between items-center relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20  rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-plus-circle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Tambah Obat Baru</h3>
                        <p class="text-green-100 text-sm">Isi data obat dengan lengkap</p>
                    </div>
                </div>
                <button type="button" onclick="closeMedicineModal()" class="w-12 h-12 bg-white/20 hover:bg-white/30  rounded-xl flex items-center justify-center text-white transition-all duration-300 hover:rotate-90 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Form Content --}}
        <div class="p-6 sm:p-8 overflow-y-auto flex-1 no-scrollbar">
            <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Error Validasi --}}
                @if ($errors->any())
                <div class="flex items-center gap-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl">
                    <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-white flex-shrink-0">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="font-bold text-red-700">🚨 Terjadi Kesalahan Input:</p>
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                {{-- Section: Data Dasar --}}
                <div class="bg-gradient-to-br from-gray-50 to-green-50/30 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-pills text-white text-sm"></i>
                        </div>
                        Informasi Dasar
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label for="name" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-tag text-green-500"></i> Nama Obat
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="input-modern-create w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                        </div>

                        <div class="space-y-2">
                            <label for="category_select2" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-folder text-green-500"></i> Kategori
                            </label>
                            <select name="category" id="category_select2" class="w-full">
                                @if(old('category'))
                                <option value="{{ old('category') }}" selected>{{ old('category') }}</option>
                                @endif
                                @foreach($existingCategories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500">Pilih dari daftar, atau ketik kategori baru.</p>
                        </div>

                        <div class="space-y-2">
                            <label for="price" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-money-bill text-emerald-500"></i> Harga (Rp)
                            </label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0"
                                class="input-modern-create w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                        </div>

                        <div class="space-y-2">
                            <label for="stock" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-boxes text-teal-500"></i> Stok Awal
                            </label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0"
                                class="input-modern-create w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-green-500 focus:outline-none">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label for="image" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-image text-purple-500"></i> Gambar Obat (Opsional, Maks 2MB)
                            </label>
                            <input type="file" name="image" id="image"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-green-50 file:text-green-600 hover:file:bg-green-100 cursor-pointer">
                        </div>
                    </div>
                </div>

                {{-- Section: Detail Informasi --}}
                <div class="bg-gradient-to-br from-gray-50 to-blue-50/30 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-white text-sm"></i>
                        </div>
                        Detail Informasi Obat
                    </h4>

                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label for="description" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-info-circle text-blue-500"></i> Deskripsi Singkat (Katalog)
                            </label>
                            <textarea name="description" id="description" rows="2" required
                                class="input-modern-create w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:outline-none resize-none">{{ old('description') }}</textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="full_indication" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i> Indikasi dan Manfaat Lengkap
                            </label>
                            <textarea name="full_indication" id="full_indication" rows="4" required
                                class="input-modern-create w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-green-500 focus:outline-none resize-none">{{ old('full_indication') }}</textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="usage_detail" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-pills text-purple-500"></i> Cara Penggunaan / Dosis
                            </label>
                            <textarea name="usage_detail" id="usage_detail" rows="3" required
                                class="input-modern-create w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:outline-none resize-none">{{ old('usage_detail') }}</textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="side_effects" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-exclamation-triangle text-amber-500"></i> Efek Samping
                            </label>
                            <textarea name="side_effects" id="side_effects" rows="3" required
                                class="input-modern-create w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:outline-none resize-none">{{ old('side_effects') }}</textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="contraindications" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                <i class="fas fa-ban text-red-500"></i> Larangan / Kontraindikasi
                            </label>
                            <textarea name="contraindications" id="contraindications" rows="3" required
                                class="input-modern-create w-full px-4 py-3 bg-white rounded-xl border-2 border-gray-200 focus:border-red-500 focus:outline-none resize-none">{{ old('contraindications') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeMedicineModal()"
                        class="flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all duration-300">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" id="createMedicineSubmit"
                        class="flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-green-500/50 hover:scale-[1.02] transition-all duration-300">
                        <i class="fas fa-save" id="createBtnIcon"></i>
                        <span id="createBtnText">Simpan Data Obat</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Select2 Modern Styling */
    .select2-container--default .select2-selection--single {
        height: 48px !important;
        padding: 0.5rem 1rem !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 0.75rem !important;
        background: white !important;
        transition: all 0.3s ease;
    }

    .select2-container--default .select2-selection--single:hover {
        border-color: #d1d5db !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #22c55e !important;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        top: 1px !important;
    }

    .select2-selection__rendered {
        line-height: 30px !important;
        color: #374151 !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 2px solid #e5e7eb !important;
        border-radius: 0.75rem !important;
        padding: 0.75rem !important;
        font-size: 1rem !important;
    }

    .select2-dropdown {
        border-radius: 0.75rem !important;
        border: 2px solid #e5e7eb !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }

    .select2-results__option--highlighted {
        background-color: #22c55e !important;
    }
</style>

<script>
    $(document).ready(function() {
        initCreateSelect2();

        // AJAX Form Submission
        document.querySelector('#medicineModal form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = document.getElementById('createMedicineSubmit');
            const btnIcon = document.getElementById('createBtnIcon');
            const btnText = document.getElementById('createBtnText');

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
                        closeMedicineModal();
                        showNotification('success', body.message);
                        refreshMedicineTable();
                    } else if (status === 422) {
                        // Validation errors
                        let errorHtml = '<div class="ajax-error-container flex items-center gap-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl mb-4">';
                        errorHtml += '<div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-white flex-shrink-0"><i class="fas fa-exclamation-triangle"></i></div>';
                        errorHtml += '<div><p class="font-bold text-red-700">🚨 Terjadi Kesalahan Input:</p><ul class="list-disc list-inside text-sm text-red-600">';

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

                        // Scroll to top of form
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
                    btnText.textContent = 'Simpan Data Obat';
                });
        });
    });

    function initCreateSelect2() {
        const select = $('#category_select2');
        const oldCategory = "{{ old('category') }}";

        if (select.data('select2')) {
            select.select2('destroy');
        }

        if (oldCategory && select.find('option[value="' + oldCategory + '"]').length === 0) {
            const newOption = new Option(oldCategory, oldCategory, true, true);
            select.append(newOption);
        }

        select.select2({
            placeholder: "Pilih kategori, atau ketik baru...",
            tags: true,
            dropdownParent: $('#medicineModal'),
        });

        select.val(oldCategory).trigger('change');
    }

    function openMedicineModal() {
        const modal = document.getElementById('medicineModal');
        const modalContent = document.getElementById('modalContent');

        document.querySelector('#medicineModal form').reset();

        // Remove any previous error containers
        const existingError = document.querySelector('#medicineModal .ajax-error-container');
        if (existingError) existingError.remove();

        initCreateSelect2();

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function closeMedicineModal() {
        const modal = document.getElementById('medicineModal');
        const modalContent = document.getElementById('modalContent');

        modalContent.classList.remove('opacity-100', 'scale-100');
        modalContent.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.querySelector('#medicineModal form').reset();
            initCreateSelect2();
        }, 300);
    }

    document.addEventListener('keydown', function(e) {
        const createModal = document.getElementById('medicineModal');
        const editModal = document.getElementById('medicineEditModal');

        if (!createModal.classList.contains('hidden') && e.key === 'Escape') {
            closeMedicineModal();
        } else if (editModal && !editModal.classList.contains('hidden') && e.key === 'Escape') {
            closeEditMedicineModal();
        }
    });
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if ("{{ session('form_type') }}" === 'create') {
            openMedicineModal();
        } else if ("{{ session('form_type') }}" === 'edit') {
            const errorId = "{{ session('edit_id') }}";
            if (errorId) {
                openMedicineEditModal(errorId);
            }
        }
    });
</script>
@endif