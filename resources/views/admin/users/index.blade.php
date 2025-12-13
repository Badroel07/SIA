@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')

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

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    .animate-slide-up {
        animation: slideInUp 0.5s ease-out forwards;
    }

    .animate-fade-in {
        animation: fadeIn 0.4s ease-out forwards;
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
        background: linear-gradient(90deg, rgba(139, 92, 246, 0.05), transparent);
        transform: scale(1.005);
    }
</style>

<div class="space-y-6">

    {{-- Header Card --}}
    <div class="glass-card p-6 rounded-3xl shadow-xl border border-gray-100 animate-slide-up">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-500/30">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h3>
                    <p class="text-gray-500">Kelola semua pengguna sistem</p>
                </div>
            </div>

            <a href="{{ route('admin.users.create') }}"
                class="group inline-flex items-center gap-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all duration-300 hover:scale-105">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-90 transition-all duration-300">
                    <i class="fas fa-plus"></i>
                </div>
                Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- Search & Filter Card --}}
    <div class="glass-card p-6 rounded-3xl shadow-xl border border-gray-100 animate-slide-up" style="animation-delay: 0.1s;">
        <form action="{{ route('admin.users.index') }}" method="GET"
            x-data="{
                searchTimeout: null,
                loading: false,
                performSearch() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.loading = true;
                        const formData = new FormData($el);
                        const params = new URLSearchParams(formData);
                        
                        fetch('{{ route('admin.users.index') }}?' + params.toString(), {
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                        })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newResults = doc.querySelector('#users-table-results');
                            const currentResults = document.querySelector('#users-table-results');
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
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-purple-50 group-focus-within:bg-purple-100 flex items-center justify-center transition-colors">
                        <i class="fas fa-search text-purple-500"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Pengguna..."
                        @input="performSearch()"
                        class="w-full pl-16 pr-4 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 placeholder-gray-400 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 focus:bg-white">
                </div>

                {{-- Role Filter --}}
                <div class="md:col-span-4 relative"
                    x-data="{ open: false, selectedLabel: '{{ request('role') ? ucfirst(request('role')) : 'Semua Role' }}', selectedValue: '{{ request('role') ?: '' }}' }"
                    @click.outside="open = false">

                    <input type="hidden" name="role" x-model="selectedValue" @change="performSearch()">

                    <button type="button" @click="open = !open"
                        class="w-full px-5 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 flex justify-between items-center focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 hover:bg-white">
                        <span class="truncate font-medium" x-text="selectedLabel"></span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute z-30 w-full mt-2 rounded-2xl shadow-2xl bg-white border border-gray-100 overflow-hidden">

                        <a href="#" class="block px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-purple-500 hover:to-indigo-600 hover:text-white transition-all"
                            @click.prevent="selectedLabel = 'Semua Role'; selectedValue = ''; open = false; performSearch()">
                            Semua Role
                        </a>

                        @foreach ($roles as $role)
                        <a href="#" class="block px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-purple-500 hover:to-indigo-600 hover:text-white transition-all"
                            @click.prevent="selectedLabel = '{{ ucfirst($role) }}'; selectedValue = '{{ $role }}'; open = false; performSearch()">
                            {{ ucfirst($role) }}
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="md:col-span-3 flex gap-2">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-4 py-4 rounded-2xl font-bold transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl hover:scale-[1.02]">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24" x-show="loading" x-cloak>
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <i class="fas fa-search" x-show="!loading"></i>
                        <span class="hidden sm:inline">Cari</span>
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-4 rounded-2xl font-bold transition-all duration-300 flex items-center justify-center gap-2 hover:scale-[1.02]">
                        <i class="fas fa-redo"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div id="users-table-results" class="glass-card rounded-3xl shadow-xl border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 0.2s;">

        <div class="overflow-x-auto no-scrollbar">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-purple-50/30">
                    <tr>
                        <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                    <tr class="table-row-hover bg-white">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center shadow-inner">
                                    @if(isset($user->profile_photo_url))
                                    <img class="w-full h-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                    @else
                                    <span class="text-2xl font-bold text-purple-600">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">ID: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="fas fa-envelope text-gray-400"></i>
                                {{ $user->email }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold rounded-xl 
                                @if($user->role === 'admin') 
                                    bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 
                                @elseif($user->role === 'cashier')
                                    bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700
                                @else
                                    bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-700 
                                @endif">
                                @if($user->role === 'admin')
                                <i class="fas fa-shield-alt"></i>
                                @elseif($user->role === 'cashier')
                                <i class="fas fa-cash-register"></i>
                                @else
                                <i class="fas fa-user"></i>
                                @endif
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="#" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                    <i class="fas fa-users text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-xl text-gray-600 font-bold mb-2">Tidak Ada Pengguna</p>
                                <p class="text-gray-400 mb-6">Belum ada pengguna yang terdaftar</p>
                                <a href="{{ route('admin.users.create') }}"
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                    <i class="fas fa-plus"></i>
                                    Tambah Pengguna
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-purple-50/30 border-t border-gray-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

@endsection