@extends('admin.layouts.app')

@section('title', 'Edit Data Obat: ' . $medicine->name)

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md max-w-4xl mx-auto">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Formulir Edit Data Obat</h3>

    {{-- Form mengarah ke route admin.medicines.update --}}
    <form action="{{ route('admin.medicines.update', $medicine) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT') {{-- WAJIB: Menggunakan method PUT untuk update --}}

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Handle Error Validasi --}}
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
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
                <input type="text" name="name" id="name" value="{{ old('name', $medicine->name) }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category" id="category" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    <option value="">Pilih Kategori</option>
                    <?php
                    $categories = ['Analgesik & Antipiretik', 'Antibiotik (Penisilin)', 'Anti-inflamasi Non-steroid (OAINS)', 'Antihistamin', 'Bronkodilator', 'Suplemen'];
                    ?>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category', $medicine->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Harga -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                <input type="number" name="price" id="price" value="{{ old('price', $medicine->price) }}" required min="0" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <!-- Stok Saat Ini (Hanya Tampilan) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Stok Saat Ini</label>
                <input type="text" value="{{ $medicine->stock }}" disabled class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm cursor-not-allowed">
            </div>

            <!-- Stok Adjustment (Fitur Penyesuaian Stok) -->
            <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-200">
                <label for="stock_adjustment" class="block text-sm font-medium text-blue-800">
                    <i class="fas fa-arrows-alt-v mr-1"></i> Penyesuaian Stok (Tambahkan/Kurangi)
                </label>
                <input type="number" name="stock_adjustment" id="stock_adjustment" placeholder="Masukkan angka positif (+) untuk menambah, atau negatif (-) untuk mengurangi"
                    value="{{ old('stock_adjustment') }}" class="mt-1 block w-full border-blue-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-gray-600 mt-1">Misal: Masukkan **10** untuk menambah 10 unit, atau **-5** untuk mengurangi 5 unit (karena rusak/hilang).</p>
            </div>


            <!-- Gambar Obat -->
            <div class="md:col-span-2 flex items-center gap-6 border-t pt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gambar Saat Ini</label>
                    @if($medicine->image)
                    <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" class="w-16 h-16 object-cover rounded-full mt-2">
                    @else
                    <span class="text-sm text-gray-500 mt-2">Tidak ada gambar</span>
                    @endif
                </div>

                <div class="flex-grow">
                    <label for="image" class="block text-sm font-medium text-gray-700">Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>
        </div>

        <!-- Deskripsi dan Detail Teknis -->
        <h4 class="text-lg font-bold text-gray-800 pt-4 border-t">Detail Informasi Obat</h4>

        <!-- Deskripsi Singkat (Katalog) -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat (Katalog)</label>
            <textarea name="description" id="description" rows="2" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('description', $medicine->description) }}</textarea>
        </div>

        <!-- Indikasi Lengkap -->
        <div>
            <label for="full_indication" class="block text-sm font-medium text-gray-700">Indikasi dan Manfaat Lengkap</label>
            <textarea name="full_indication" id="full_indication" rows="4" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('full_indication', $medicine->full_indication) }}</textarea>
        </div>

        <!-- Cara Penggunaan -->
        <div>
            <label for="usage_detail" class="block text-sm font-medium text-gray-700">Cara Penggunaan / Dosis</label>
            <textarea name="usage_detail" id="usage_detail" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('usage_detail', $medicine->usage_detail) }}</textarea>
        </div>

        <!-- Efek Samping -->
        <div>
            <label for="side_effects" class="block text-sm font-medium text-gray-700">Efek Samping</label>
            <textarea name="side_effects" id="side_effects" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('side_effects', $medicine->side_effects) }}</textarea>
        </div>

        <!-- Kontraindikasi -->
        <div>
            <label for="contraindications" class="block text-sm font-medium text-gray-700">Larangan / Kontraindikasi</label>
            <textarea name="contraindications" id="contraindications" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('contraindications', $medicine->contraindications) }}</textarea>
        </div>


        <div class="flex justify-end pt-4">
            <a href="{{ route('admin.medicines.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-bold transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition ml-3">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection