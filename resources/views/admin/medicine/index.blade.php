@extends('admin.layouts.app')

@section('title', 'Manajemen Data Obat')

@section('content')

<style>
    @keyframes slideInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        0% {
            opacity: 0;
            transform: translateX(-20px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes pulse-subtle {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }
    }

    .animate-slide-up {
        animation: slideInUp 0.5s ease-out forwards;
    }

    .animate-slide-left {
        animation: slideInLeft 0.4s ease-out forwards;
    }

    .animate-fade-in {
        animation: fadeIn 0.4s ease-out forwards;
    }

    .animate-pulse-subtle {
        animation: pulse-subtle 2s ease-in-out infinite;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.15);
    }

    .table-row-hover {
        transition: all 0.2s ease;
    }

    .table-row-hover:hover {
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.05), transparent);
        transform: scale(1.005);
    }
</style>

<div class="space-y-6">

    {{-- Notifikasi Modern --}}
    @if(session('success'))
    <div id="notification-alert"
        class="glass-card border-l-4 border-green-500 px-6 py-4 rounded-2xl shadow-lg flex items-center gap-4 animate-slide-up opacity-0"
        role="alert">
        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-bold text-gray-800">Berhasil!</p>
            <p class="text-gray-600">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('notification-alert').remove()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Header Card --}}
    <div class="glass-card p-6 rounded-3xl shadow-xl border border-gray-100 animate-slide-up">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <i class="fas fa-pills text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Manajemen Obat</h3>
                    <p class="text-gray-500">Total <span class="font-bold text-blue-600">{{ $medicines->total() ?? 0 }}</span> jenis obat tersedia</p>
                </div>
            </div>

            <button onclick="openMedicineModal()"
                class="group inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-90 transition-all duration-300">
                    <i class="fas fa-plus"></i>
                </div>
                Tambah Obat
            </button>
        </div>
    </div>

    {{-- Search & Filter Card --}}
    <div class="glass-card p-6 rounded-3xl shadow-xl border border-gray-100 animate-slide-up relative z-20" style="animation-delay: 0.1s;">
        <form action="{{ route('admin.medicines.index') }}" method="GET"
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
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                        })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newResults = doc.querySelector('#medicine-table-results');
                            const currentResults = document.querySelector('#medicine-table-results');
                            if (newResults && currentResults) { currentResults.innerHTML = newResults.innerHTML; }
                            this.loading = false;
                        })
                        .catch(error => { console.error('Search error:', error); this.loading = false; });
                    }, 400);
                }
            }">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                {{-- Search Input --}}
                <div class="md:col-span-5 relative group">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-blue-50 group-focus-within:bg-blue-100 flex items-center justify-center transition-colors">
                        <i class="fas fa-search text-blue-500"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Obat..."
                        @input="performSearch()"
                        class="w-full pl-16 pr-4 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 focus:bg-white">
                </div>

                {{-- Category Dropdown --}}
                <div class="md:col-span-4 relative"
                    x-data="{ open: false, selectedLabel: '{{ request('category') == 'all' ? 'Semua Kategori' : (request('category') ?: 'Semua Kategori') }}', selectedValue: '{{ request('category') ?: 'all' }}' }"
                    @click.outside="open = false">

                    <input type="hidden" name="category" x-model="selectedValue" @change="performSearch()">

                    <button type="button" @click="open = !open"
                        class="w-full px-5 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 flex justify-between items-center focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 hover:bg-white">
                        <span class="truncate font-medium" x-text="selectedLabel"></span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute z-30 w-full mt-2 rounded-2xl shadow-2xl bg-white border border-gray-100 overflow-hidden max-h-60 overflow-y-auto">

                        <a href="#" class="block px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-600 hover:text-white transition-all"
                            @click.prevent="selectedLabel = 'Semua Kategori'; selectedValue = 'all'; open = false; performSearch()">
                            Semua Kategori
                        </a>

                        @foreach($categories as $cat)
                        <a href="#" class="block px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-600 hover:text-white transition-all"
                            @click.prevent="selectedLabel = '{{ $cat }}'; selectedValue = '{{ $cat }}'; open = false; performSearch()">
                            {{ $cat }}
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="md:col-span-3 flex gap-2">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-4 rounded-2xl font-bold transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl hover:scale-[1.02]">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24" x-show="loading" x-cloak>
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <i class="fas fa-search" x-show="!loading"></i>
                        <span class="hidden sm:inline">Cari</span>
                    </button>

                    <a href="{{ route('admin.medicines.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-4 rounded-2xl font-bold transition-all duration-300 flex items-center justify-center gap-2 hover:scale-[1.02]">
                        <i class="fas fa-redo"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div id="medicine-table-results" class="glass-card rounded-3xl shadow-xl border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 0.2s;">

        @forelse($medicines as $item)
        @if($loop->first)
        <div class="overflow-x-auto no-scrollbar">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-blue-50/30">
                    <tr>
                        <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Terjual</th>
                        <th class="px-6 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @endif

                    <tr class="table-row-hover bg-white">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center shadow-inner">
                                    @if($item->image)
                                    <img src="{{ Storage::disk('public')->url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                    <i class="fas fa-capsules text-2xl text-blue-300"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $item->name }}</p>
                                    <p class="text-xs text-gray-400">ID: #{{ $item->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1.5 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700">
                                {{ $item->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-lg font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-bold rounded-xl {{ $item->stock > 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700 animate-pulse-subtle' }}">
                                @if($item->stock <= 10)
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                    @endif
                                    {{ $item->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-bold rounded-xl bg-purple-100 text-purple-700">
                                <i class="fas fa-shopping-bag text-xs"></i>
                                {{ $item->total_sold ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openMedicineDetailModal({{ $item->id }})"
                                    class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="openMedicineEditModal({{ $item->id }})"
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.medicines.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus {{ $item->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-10 h-10 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @if($loop->last)
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50/30 border-t border-gray-100">
            {{ $medicines->links() }}
        </div>
        @endif

        @empty
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-20">
            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-pills text-4xl text-gray-400"></i>
            </div>
            <p class="text-2xl text-gray-600 font-bold mb-2">Tidak Ada Data Obat</p>
            <p class="text-gray-400 mb-6">Silakan tambahkan obat baru untuk memulai</p>
            <button onclick="openMedicineModal()"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-plus"></i>
                Tambah Obat Baru
            </button>
        </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.getElementById('notification-alert');
        if (notification) {
            setTimeout(() => {
                notification.classList.remove('opacity-0');
                notification.classList.add('opacity-100');
            }, 10);
            setTimeout(() => {
                notification.classList.remove('opacity-100');
                notification.classList.add('opacity-0');
                setTimeout(() => notification.remove(), 500);
            }, 5000);
        }
    });
</script>

{{-- MODAL INCLUDES --}}
@push('modals')
@include('components.detail_obat')
@include('admin.medicine.create')
@include('admin.medicine.edit')
@endpush

@endsection