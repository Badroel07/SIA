{{-- Container Utama Modal Edit --}}
<div id="medicineEditModal" class="hidden fixed inset-0 backdrop-blur-sm backdrop-brightness-50 overflow-y-auto h-full w-full z-50 p-4 sm:p-6">

    <div id="editModalContent"
        class="relative top-10 mx-auto w-full max-w-4xl shadow-2xl rounded-xl bg-white mb-10 transform opacity-0 scale-95 transition-all duration-300 ease-out">

        <div class="p-6 sm:p-8">
            {{-- Header Modal --}}
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                <h3 class="text-2xl font-extrabold text-gray-900">Edit Data Obat: <span id="edit-modal-name" class="text-blue-600"></span></h3>
                <button type="button" onclick="closeEditMedicineModal()" class="text-gray-400 hover:text-red-500 text-3xl font-bold transition duration-150">&times;</button>
            </div>

            {{-- Form Content --}}
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Handle Error Validasi (Jika ada error saat submit form edit) --}}
                @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                    <p class="font-bold">Terjadi Kesalahan Input:</p>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="space-y-1">
                        <label for="edit-name" class="block text-sm font-semibold text-gray-700">Nama Obat</label>
                        <input type="text" name="name" id="edit-name" value="" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 transition duration-150">
                    </div>

                    {{-- START: FIELD KATEGORI (MENGGUNAKAN SELECT2 DENGAN TAGS DAN OPSIONAL) --}}
                    <div class="space-y-1">
                        <label for="edit-category-select2" class="block text-sm font-semibold text-gray-700">Kategori</label>
                        <div class="mt-1">
                            {{-- Atribut required DIHAPUS, Select2 akan diaktifkan dengan Tags --}}
                            <select name="category" id="edit-category-select2" class="w-full">
                                {{-- Opsi kosong untuk nilai null/opsional --}}
                                <option value="">-- Pilih Kategori (Opsional, atau ketik baru) --</option>
                                {{-- Opsi kategori yang sudah ada --}}
                                @foreach($existingCategories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>

                            {{-- Input Teks Manual Kategori BARU sudah tidak diperlukan karena dihandle oleh Select2 Tags --}}
                        </div>
                    </div>
                    {{-- END: FIELD KATEGORI --}}

                    <div class="space-y-1">
                        <label for="edit-price" class="block text-sm font-semibold text-gray-700">Harga (Rp)</label>
                        <input type="number" name="price" id="edit-price" value="" required min="0"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 transition duration-150">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700">Stok Saat Ini</label>
                        <input type="text" id="edit-current-stock" value="" disabled
                            class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm p-2.5 cursor-not-allowed">
                    </div>

                    {{-- Bagian penyesuaian stok yang dimodifikasi --}}
                    <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <label for="edit-stock-adjustment" class="block text-sm font-medium text-blue-800 mb-1">
                            <i class="fas fa-arrows-alt-v mr-1"></i> Penyesuaian Stok (Tambahkan/Kurangi)
                        </label>
                        <input type="number" name="stock_adjustment" id="edit-stock-adjustment" placeholder="Masukkan angka positif (+) untuk menambah, atau negatif (-) untuk mengurangi"
                            value=""
                            class="mt-1 block w-full border border-blue-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5">
                        <p class="text-xs text-gray-600 mt-2">Misal: Masukkan 10 untuk menambah 10 unit, atau -5 untuk mengurangi 5 unit.</p>

                        {{-- Tambahkan radio button untuk alasan pengurangan stok --}}
                        <div id="stock-reason-container" class="mt-4 hidden">
                            <label class="block text-sm font-medium text-blue-800 mb-2">Alasan Pengurangan Stok:</label>
                            <div class="flex space-x-6">
                                <div class="flex items-center">
                                    <input id="sold-reason" name="stock_reason" value="sold" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                    <label for="sold-reason" class="ml-2 block text-sm text-gray-700">Terjual</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="other-reason" name="stock_reason" value="other" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" checked>
                                    <label for="other-reason" class="ml-2 block text-sm text-gray-700">Lainnya (hilang, rusak, dll)</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="md:col-span-2 flex items-center gap-6 border-t pt-4">
                        <div class="flex-shrink-0">
                            <label class="block text-sm font-semibold text-gray-700">Gambar Saat Ini</label>
                            <img id="edit-current-image" src="" alt="Gambar Obat" class="w-16 h-16 object-cover rounded-full mt-2 border border-gray-200 shadow-sm">
                            <span id="edit-no-image" class="text-sm text-gray-500 mt-2 hidden">Tidak ada gambar</span>
                        </div>

                        <div class="flex-grow">
                            <label for="edit-image" class="block text-sm font-medium text-gray-700">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" id="edit-image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <h4 class="text-lg font-bold text-gray-800 pt-4 border-t">Detail Informasi Obat</h4>

                @php
                $detailFields = [
                'description' => ['label' => 'Deskripsi Singkat (Katalog)', 'rows' => 2],
                'full_indication' => ['label' => 'Indikasi dan Manfaat Lengkap', 'rows' => 4],
                'usage_detail' => ['label' => 'Cara Penggunaan / Dosis', 'rows' => 3],
                'side_effects' => ['label' => 'Efek Samping', 'rows' => 3],
                'contraindications' => ['label' => 'Larangan / Kontraindikasi', 'rows' => 3]
                ];
                @endphp

                @foreach($detailFields as $name => $data)
                <div class="space-y-1">
                    <label for="edit-{{ $name }}" class="block text-sm font-semibold text-gray-700">{{ $data['label'] }}</label>
                    <textarea name="{{ $name }}" id="edit-{{ $name }}" rows="{{ $data['rows'] }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 transition duration-150"></textarea>
                </div>
                @endforeach


                <div class="flex justify-end pt-4 gap-3 border-t">
                    <button type="button" onclick="closeEditMedicineModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-bold transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow-md transition ml-3">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const baseUrl = "{{ url('/') }}";

    // --- 1. Fungsi Inisialisasi Select2 Edit (FINAL dengan Tags) ---
    function initEditSelect2(currentCategory) {
        const select = $('#edit-category-select2');

        if (select.data('select2')) {
            select.select2('destroy');
        }

        const categoryToSelect = currentCategory || '';

        // Cek apakah kategori saat ini ada di daftar opsi yang tersedia
        const isExisting = select.find('option[value="' + categoryToSelect + '"]').length > 0;

        // Jika kategori saat ini TIDAK ada di daftar, kita tambahkan opsi tersebut 
        // agar data lama tetap muncul dan terpilih, penting untuk Select2 Tags
        if (!isExisting && categoryToSelect) {
            const newOption = new Option(categoryToSelect, categoryToSelect, true, true);
            select.append(newOption);
        }

        // Re-inisialisasi Select2 DENGAN tags: true
        select.select2({
            placeholder: "Pilih kategori, atau ketik untuk menambah baru...",
            dropdownParent: $('#medicineEditModal'),
            allowClear: true,
            tags: true, // **MENGAKTIFKAN INPUT MANUAL/TAGS**
        });

        // Memastikan Select2 memilih nilai kategori saat ini
        select.val(categoryToSelect).trigger('change');
    }

    // --- 2. Fungsi Utama untuk Membuka Modal Edit ---
    function openMedicineEditModal(id) {
        const modal = document.getElementById('medicineEditModal');
        const modalContent = document.getElementById('editModalContent');
        const form = document.getElementById('editForm');

        // 0. Reset dan Persiapan
        form.reset();
        document.getElementById('edit-stock-adjustment').value = '';

        // 1. Ambil Data Obat melalui AJAX
        $.getJSON(baseUrl + '/admin/medicines/' + id + '/detail', function(data) {

            // 2. Isi Form Action (URL untuk PUT)
            form.action = baseUrl + '/admin/medicines/' + id;

            // 3. Isi Field Dasar
            document.getElementById('edit-modal-name').textContent = data.name;
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-price').value = data.price;
            document.getElementById('edit-current-stock').value = data.stock;

            // 4. Isi Field Detail (Textarea)
            document.getElementById('edit-description').value = data.description || '';
            document.getElementById('edit-full_indication').value = data.full_indication || '';
            document.getElementById('edit-usage_detail').value = data.usage_detail || '';
            document.getElementById('edit-side_effects').value = data.side_effects || '';
            document.getElementById('edit-contraindications').value = data.contraindications || '';

            // 5. Handle Gambar - PERBAIKAN DI SINI
            const img = document.getElementById('edit-current-image');
            const noImgSpan = document.getElementById('edit-no-image');

            if (data.image) {
                // Gunakan image_url dari backend yang sudah berisi full S3 URL
                // ATAU buat sendiri dengan menambahkan S3 base URL
                img.src = data.image_url || data.image; // Pastikan backend mengirim image_url
                img.classList.remove('hidden');
                noImgSpan.classList.add('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                noImgSpan.classList.remove('hidden');
            }

            // 6. Inisialisasi dan Set Select2 Kategori
            initEditSelect2(data.category);

            // 7. Tampilkan Modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Animasi
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        });
    }


    // --- 3. Fungsi untuk Menutup Modal Edit ---
    function closeEditMedicineModal() {
        const modal = document.getElementById('medicineEditModal');
        const modalContent = document.getElementById('editModalContent');

        // Animasi
        modalContent.classList.remove('opacity-100', 'scale-100');
        modalContent.classList.add('opacity-0', 'scale-95');

        // Sembunyikan setelah transisi selesai (300ms)
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Tambahkan ini di bagian JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        const stockAdjustmentInput = document.getElementById('edit-stock-adjustment');
        const stockReasonContainer = document.getElementById('stock-reason-container');

        stockAdjustmentInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            if (isNaN(value)) {
                stockReasonContainer.classList.add('hidden');
            } else if (value < 0) {
                stockReasonContainer.classList.remove('hidden');
            } else {
                stockReasonContainer.classList.add('hidden');
            }
        });
    });
</script>