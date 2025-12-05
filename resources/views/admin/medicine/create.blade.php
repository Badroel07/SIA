{{-- Modal Overlay untuk Form Tambah Obat --}}
{{-- Class backdrop-blur dan bg-opacity-30 memberikan efek blur transparan modern --}}
<div id="medicineModal" class="hidden fixed inset-0 backdrop-blur-sm backdrop-brightness-50 overflow-y-auto h-full w-full z-50 p-4 sm:p-6">

    {{-- Container konten modal dengan animasi CSS kustom --}}
    <div id="modalContent"
        class="relative top-10 mx-auto w-full max-w-4xl shadow-2xl rounded-xl bg-white mb-10 transform opacity-0 scale-95 transition-all duration-300 ease-out">

        <div class="p-6 sm:p-8">
            {{-- Header Modal --}}
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                <h3 class="text-2xl font-extrabold text-gray-900">Input Data Obat</h3>
                <button type="button" onclick="closeMedicineModal()" class="text-gray-400 hover:text-red-500 text-3xl font-bold transition duration-150">&times;</button>
            </div>

            {{-- Form Content --}}
            <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Error Validasi --}}
                @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                    <p class="font-extrabold">🚨 Terjadi Kesalahan Input:</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Bagian 1: Data Dasar --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label for="name" class="block text-sm font-semibold text-gray-700">Nama Obat</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 transition duration-150">
                    </div>

                    {{-- Kategori (Menggunakan Select2 DENGAN TAGS) --}}
                    <div class="space-y-1">
                        <label for="category_select2" class="block text-sm font-semibold text-gray-700">Kategori</label>
                        <div class="mt-1">
                            {{-- Select ini akan di-init dengan tags: true --}}
                            <select name="category" id="category_select2" class="w-full">
                                {{-- Jika ada old value, pastikan itu muncul di select --}}
                                @if(old('category'))
                                <option value="{{ old('category') }}" selected>{{ old('category') }}</option>
                                @endif
                                {{-- Opsi kategori yang sudah ada --}}
                                @foreach($existingCategories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            {{-- INPUT TEKS MANUAL DIHAPUS, DIGANTI OLEH Select2 Tags --}}
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Pilih dari daftar, atau ketik kategori baru lalu tekan Enter/Tab.</p>
                    </div>


                    <div class="space-y-1">
                        <label for="price" class="block text-sm font-semibold text-gray-700">Harga (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 transition duration-150">
                    </div>

                    <div class="space-y-1">
                        <label for="stock" class="block text-sm font-semibold text-gray-700">Stok Awal</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 transition duration-150">
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label for="image" class="block text-sm font-semibold text-gray-700">Gambar Obat (Opsional, Maks 2MB)</label>
                        <input type="file" name="image" id="image"
                            class="mt-1 block w-full text-sm text-gray-500 
                                file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 
                                file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 
                                hover:file:bg-blue-100 cursor-pointer">
                    </div>
                </div>

                <div class="border-t pt-8">
                    <h4 class="text-xl font-extrabold text-gray-900 mb-4">Detail Informasi Obat</h4>
                </div>

                {{-- Bagian 2: Detail Informasi --}}
                <div class="space-y-6">
                    <div class="space-y-1">
                        <label for="description" class="block text-sm font-semibold text-gray-700">Deskripsi Singkat (Katalog)</label>
                        <textarea name="description" id="description" rows="2" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 transition duration-150">{{ old('description') }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="full_indication" class="block text-sm font-semibold text-gray-700">Indikasi dan Manfaat Lengkap</label>
                        <textarea name="full_indication" id="full_indication" rows="4" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 transition duration-150">{{ old('full_indication') }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="usage_detail" class="block text-sm font-semibold text-gray-700">Cara Penggunaan / Dosis</label>
                        <textarea name="usage_detail" id="usage_detail" rows="3" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 transition duration-150">{{ old('usage_detail') }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="side_effects" class="block text-sm font-semibold text-gray-700">Efek Samping</label>
                        <textarea name="side_effects" id="side_effects" rows="3" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 transition duration-150">{{ old('side_effects') }}</textarea>
                    </div>

                    <div class="space-y-1">
                        <label for="contraindications" class="block text-sm font-semibold text-gray-700">Larangan / Kontraindikasi</label>
                        <textarea name="contraindications" id="contraindications" rows="3" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 transition duration-150">{{ old('contraindications') }}</textarea>
                    </div>
                </div>

                {{-- Button Actions --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <button type="button" onclick="closeMedicineModal()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-bold transition duration-150">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow-md transition duration-150 ease-in-out">
                        Simpan Data Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* |--------------------------------------------------------------------------
| CSS Kustom Select2 (Meniru Gaya Tailwind)
|--------------------------------------------------------------------------
*/
    .select2-container--default .select2-selection--single {
        height: 40px !important;
        padding: 0.375rem 0.75rem !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        transition: all 0.15s ease-in-out;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 1px #3b82f6 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px !important;
        top: 1px !important;
    }

    .select2-selection__rendered {
        line-height: 25px !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 0.5rem !important;
        margin-top: 0.5rem !important;
        font-size: 1rem !important;
    }

    .select2-dropdown {
        border-radius: 0.5rem !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }
</style>

<script>
    $(document).ready(function() {
        initCreateSelect2(); // Pastikan Select2 modal Create ter-init saat halaman dimuat
    });

    // === 1. SELECT2 INITIALIZERS ===

    function initCreateSelect2() {
        const select = $('#category_select2');
        const oldCategory = "{{ old('category') }}";

        if (select.data('select2')) {
            select.select2('destroy');
        }

        // Handle Old Value untuk Select2 Tags (jika validasi gagal)
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
            placeholder: "Pilih kategori (Opsional, atau ketik baru)...",
            dropdownParent: $('#medicineEditModal'),
            allowClear: true,
            tags: true,
        });

        select.val(categoryToSelect).trigger('change');
    }

    // === 2. MODAL CREATE LOGIC ===

    function openMedicineModal() {
        const modal = document.getElementById('medicineModal');
        const modalContent = document.getElementById('modalContent');

        document.querySelector('#medicineModal form').reset();
        initCreateSelect2(); // Re-init Select2

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

    // === 3. MODAL EDIT LOGIC ===

    function openMedicineEditModal(id) {
        const modal = document.getElementById('medicineEditModal');
        const modalContent = document.getElementById('editModalContent');
        const form = document.getElementById('editForm');

        form.reset();
        document.getElementById('edit-stock-adjustment').value = '';

        // Ambil Data Obat melalui AJAX
        $.getJSON(baseUrl + '/admin/medicines/' + id + '/detail', function(data) {

            // Isi Form Action (URL untuk PUT)
            form.action = baseUrl + '/admin/medicines/' + id;

            // Isi Field Dasar
            document.getElementById('edit-modal-name').textContent = data.name;
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-price').value = data.price;
            document.getElementById('edit-current-stock').value = data.stock;

            // Isi Field Detail (Textarea)
            document.getElementById('edit-description').value = data.description || '';
            document.getElementById('edit-full_indication').value = data.full_indication || '';
            document.getElementById('edit-usage_detail').value = data.usage_detail || '';
            document.getElementById('edit-side_effects').value = data.side_effects || '';
            document.getElementById('edit-contraindications').value = data.contraindications || '';

            // Handle Gambar
            const img = document.getElementById('edit-current-image');
            const noImgSpan = document.getElementById('edit-no-image');
            const storagePath = baseUrl + '/storage/';

            if (data.image) {
                img.src = storagePath + data.image;
                img.classList.remove('hidden');
                noImgSpan.classList.add('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                noImgSpan.classList.remove('hidden');
            }

            // Inisialisasi dan Set Select2 Kategori
            initEditSelect2(data.category);

            // Tampilkan Modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Animasi
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

    // === 4. GLOBAL LOGIC ===

    // FUNGSI ESCAPE
    document.addEventListener('keydown', function(e) {
        const createModal = document.getElementById('medicineModal');
        const editModal = document.getElementById('medicineEditModal');

        if (!createModal.classList.contains('hidden') && e.key === 'Escape') {
            closeMedicineModal();
        } else if (!editModal.classList.contains('hidden') && e.key === 'Escape') {
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