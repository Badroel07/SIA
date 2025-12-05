@extends('admin.layouts.app')

@section('title', 'Manajemen Data Obat')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md">

    {{-- Notifikasi (Misalnya setelah Tambah/Edit/Hapus Data) --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Daftar Obat ({{ $medicines->total() ?? 0 }} Jenis)</h3>

        <!-- Tombol Tambah Obat Baru -->
        <button onclick="openMedicineModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2 shadow-md">
            <i class="fas fa-plus"></i> Tambah Obat Baru
        </button>
    </div>

    <!-- Search & Filter Form -->
    <form action="{{ route('admin.medicines.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 mb-8">

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Obat, Indikasi..."
            class="flex-grow border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">

        <select name="category" class="border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full md:w-48">
            <option value="">Semua Kategori</option>
            {{-- Asumsi $categories dikirim dari Controller --}}
            @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition w-full md:w-auto">
            Cari
        </button>
    </form>

    <!-- Tabel Data Obat -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Terjual</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($medicines as $item)
                <tr>
                    <td class="px-6 py-4">
                        @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover rounded-full">
                        @else
                        <i class="fas fa-capsules text-xl text-gray-400"></i>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $item->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $item->category }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                        {{-- Stok: Highlight jika rendah --}}
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->stock > 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->stock }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600 font-semibold">
                        {{-- total_sold sudah ada di Model Anda --}}
                        {{ $item->total_sold ?? 0 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                        <!-- Tombol Edit (Aksi Kelola Stok/Detail) -->
                        <a href="{{ route('admin.medicines.edit', $item) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                            Edit
                        </a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('admin.medicines.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus {{ $item->name }}? Stok: {{ $item->stock }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $medicines->links() }}
    </div>
</div>



@endsection