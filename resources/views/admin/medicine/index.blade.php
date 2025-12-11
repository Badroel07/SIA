@extends('admin.layouts.app')

@section('title', 'Manajemen Data Obat')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md">

    {{-- Notifikasi dengan Class Transisi Awal --}}
    @if(session('success'))
    <div id="notification-alert"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 
            transition-opacity duration-500 ease-in-out opacity-0"
        role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Daftar Obat ({{ $medicines->total() ?? 0 }} Jenis)</h3>

        <a onclick="openMedicineModal()"
            class="inline-flex items-center 
          bg-blue-600 hover:bg-blue-700 
          text-white 
          font-bold 
          py-2 px-4 
          rounded-lg 
          shadow-md 
          transition duration-150 ease-in-out cursor-pointer">
            <i class="fas fa-plus mr-2"></i> Tambah Obat
        </a>
    </div>

    <form action="{{ route('admin.medicines.index') }}" method="GET" class="mb-8"
        x-data="{
            searchTimeout: null,
            loading: false,
            performSearch() {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.loading = true;
                    const formData = new FormData($el);
                    const params = new URLSearchParams(formData);
                    
                    fetch('{{ route('admin.medicines.index') }}?' + params.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newResults = doc.querySelector('#medicine-table-results');
                        const currentResults = document.querySelector('#medicine-table-results');
                        
                        if (newResults && currentResults) {
                            currentResults.innerHTML = newResults.innerHTML;
                        }
                        
                        this.loading = false;
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        this.loading = false;
                    });
                }, 400);
            }
        }">

        {{-- Input Cari Nama Obat DENGAN IKON SEARCH --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-6 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-500"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Obat..."
                    @input="performSearch()"
                    class="w-full pl-10 pr-4 py-3 bg-gray-100 rounded-lg border-none text-gray-700 placeholder-gray-400 focus:ring-2 transition">
            </div>

            <div class="md:col-span-3 relative"
                x-data="{ open: false, selectedLabel: '{{ request('category') == 'all' ? 'Semua Kategori' : (request('category') ?: 'Semua Kategori') }}', selectedValue: '{{ request('category') ?: 'all' }}' }"
                @click.outside="open = false">

                <input type="hidden" name="category" x-model="selectedValue" @change="performSearch()">

                <button type="button" @click="open = !open"
                    class="w-full px-4 py-3 bg-gray-100 rounded-lg border-none text-gray-700 flex justify-between items-center focus:outline-none focus:ring-2 transition">
                    <span class="truncate" x-text="selectedLabel"></span>
                    <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-9"></path>
                    </svg>
                </button>

                <div x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute z-30 w-full mt-2 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 overflow-hidden max-h-60 overflow-y-auto">

                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white transition"
                        @click.prevent="selectedLabel = 'Semua Kategori'; selectedValue = 'all'; open = false">
                        Semua Kategori
                    </a>

                    @foreach($categories as $cat)
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white transition"
                        @click.prevent="selectedLabel = '{{ $cat }}'; selectedValue = '{{ $cat }}'; open = false">
                        {{ $cat }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" x-show="loading" x-cloak>
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <i class="fas fa-search mr-2" x-show="!loading"></i> Cari
                </button>

                {{-- TOMBOL RESET --}}
                <a href="{{ route('admin.medicines.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </div>
    </form>

    {{-- TABEL DATA OBAT ATAU PESAN KOSONG --}}
    <div id="medicine-table-results">
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            @forelse($medicines as $item)
            @if($loop->first)
            {{-- Buka <table> hanya sekali di iterasi pertama --}}
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
                    @endif

                    {{-- Row data obat --}}
                    <tr>
                        <td class="px-6 py-4">
                            @if($item->image)
                            <img src="{{ Storage::disk('s3')->url($item->image) }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover rounded-full">
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

                            <button onclick="openMedicineDetailModal({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                <i class="fas fa-eye"></i> Detail
                            </button>

                            <button onclick="openMedicineEditModal({{ $item->id }})" class="text-blue-600 hover:text-blue-900 font-medium">
                                Edit
                            </button>

                            <form action="{{ route('admin.medicines.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus {{ $item->name }}? Stok: {{ $item->stock }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    @if($loop->last)
                    {{-- Tutup </tbody> dan </table> hanya sekali di iterasi terakhir --}}
                </tbody>
            </table>
            @endif

            @empty
            {{-- Tampilan ketika tidak ada data --}}
            <div class="flex flex-col items-center justify-center py-12">
                <i class="fas fa-pills text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-500 font-medium mb-2">TIDAK ADA DATA OBAT</p>
                <p class="text-gray-400 mb-4">Silakan tambah obat baru</p>
                <button onclick="openMedicineModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i> Tambah Obat Baru
                </button>
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $medicines->links() }}
        </div>
    </div> {{-- Close medicine-table-results --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.getElementById('notification-alert');

        if (notification) {
            // --- 1. Animasi Masuk (Fade-in) ---
            // Tambahkan sedikit penundaan (misalnya 10ms) agar transisi CSS bekerja
            setTimeout(function() {
                notification.classList.remove('opacity-0');
                notification.classList.add('opacity-100');
            }, 10);

            // --- 2. Animasi Keluar (Fade-out) setelah 5 detik ---
            setTimeout(function() {
                // Mulai Animasi Fade-out (500ms)
                notification.classList.remove('opacity-100');
                notification.classList.add('opacity-0');

                // Hapus elemen dari DOM setelah animasi Fade-out selesai (500ms)
                setTimeout(function() {
                    notification.remove();
                }, 500); // 500ms = Durasi transisi yang kita tetapkan (duration-500)

            }, 5000); // <-- Total waktu tunggu (5 detik)
        }
    });
</script>

{{-- MODAL INCLUDES --}}
{{-- PENTING: Pastikan variabel $existingCategories tersedia untuk modal create --}}
@include('components.detail_obat')
@include('admin.medicine.create')
@include('admin.medicine.edit')

@endsection