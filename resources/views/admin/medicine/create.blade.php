{{-- Modal Overlay untuk Form Tambah Obat --}}
<div id="medicineModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-xl bg-white mb-10">
        {{-- Header Modal --}}
        <div class="flex justify-between items-center border-b pb-3 mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Formulir Input Data Obat</h3>
            <button onclick="closeMedicineModal()" class="text-gray-400 hover:text-gray-600 text-3xl font-bold">&times;</button>
        </div>

        {{-- Form Content --}}
        <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <p class="font-bold">Terjadi Kesalahan Input:</p>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Obat -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Obat</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category" id="category" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Kategori</option>
                        <?php
                        $categories = ['Analgesik & Antipiretik', 'Antibiotik (Penisilin)', 'Anti-inflamasi Non-steroid (OAINS)', 'Antihistamin', 'Bronkodilator', 'Suplemen'];
                        ?>
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Stok Awal -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stok Awal</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Gambar Obat -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar Obat (Opsional, Maks 2MB)</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <!-- Detail Informasi Obat -->
            <h4 class="text-lg font-bold text-gray-800 pt-4 border-t">Detail Informasi Obat</h4>

            <!-- Deskripsi Singkat -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat (Katalog)</label>
                <textarea name="description" id="description" rows="2" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
            </div>

            <!-- Indikasi Lengkap -->
            <div>
                <label for="full_indication" class="block text-sm font-medium text-gray-700">Indikasi dan Manfaat Lengkap</label>
                <textarea name="full_indication" id="full_indication" rows="4" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('full_indication') }}</textarea>
            </div>

            <!-- Cara Penggunaan -->
            <div>
                <label for="usage_detail" class="block text-sm font-medium text-gray-700">Cara Penggunaan / Dosis</label>
                <textarea name="usage_detail" id="usage_detail" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('usage_detail') }}</textarea>
            </div>

            <!-- Efek Samping -->
            <div>
                <label for="side_effects" class="block text-sm font-medium text-gray-700">Efek Samping</label>
                <textarea name="side_effects" id="side_effects" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('side_effects') }}</textarea>
            </div>

            <!-- Kontraindikasi -->
            <div>
                <label for="contraindications" class="block text-sm font-medium text-gray-700">Larangan / Kontraindikasi</label>
                <textarea name="contraindications" id="contraindications" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('contraindications') }}</textarea>
            </div>

            <!-- Button Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" onclick="closeMedicineModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-bold transition">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition">
                    Simpan Data Obat
                </button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript untuk kontrol modal --}}
<script>
    function openMedicineModal() {
        document.getElementById('medicineModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling on body
    }

    function closeMedicineModal() {
        document.getElementById('medicineModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Close modal when clicking outside
    document.getElementById('medicineModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeMedicineModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMedicineModal();
        }
    });
</script>

@if ($errors->any())
<script>
    // Auto-open modal jika ada error validasi
    openMedicineModal();
</script>
@endif