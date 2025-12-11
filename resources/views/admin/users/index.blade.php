@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">

    {{-- HEADER DAN TOMBOL TAMBAH PENGGUNA --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Pengguna</h1>

        {{-- Tombol Tambah Pengguna (Biru) --}}
        <a href="{{ route('admin.users.create') }}" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-lg transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Pengguna
        </a>
    </div>

    {{-- KONTEN UTAMA: PENCARIAN, FILTER, DAN TOMBOL AKSI --}}
    <div class="bg-white shadow-xl rounded-xl p-4 sm:p-6">

        {{-- FORM PENCARIAN DAN FILTER --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-6"
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
                            if (newResults && currentResults) {
                                currentResults.innerHTML = newResults.innerHTML;
                            }
                            this.loading = false;
                        })
                        .catch(error => { console.error('Search error:', error); this.loading = false; });
                    }, 400);
                }
            }">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">

                {{-- Search Bar --}}
                <div class="flex-grow max-w-lg">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Pengguna..." @input="performSearch()" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-700">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    {{-- Role Filter --}}
                    <select name="role" @change="performSearch()" class="py-2 px-3 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-700">
                        <option value="">Filter Role</option>
                        {{-- Lakukan perulangan data $roles yang dikirim dari Controller --}}
                        @foreach ($roles as $role)
                        <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                            {{-- Ubah huruf pertama menjadi kapital (Admin, Pengguna) --}}
                            {{ ucfirst($role) }}
                        </option>
                        @endforeach
                    </select>

                    {{-- Tombol Cari --}}
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center" :disabled="loading">
                        <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" x-show="loading" x-cloak>
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <i class="fa-solid fa-magnifying-glass" x-show="!loading"></i> Cari
                    </button>

                    {{-- Tombol Reset --}}
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg shadow transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div id="users-table-results">
            {{-- TABLE DATA USERS --}}
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                GAMBAR
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NAMA LENGKAP
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                EMAIL
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ROLE
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                AKSI
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @if ($users->isEmpty())
                        <tr>
                            <td colspan="7" class="px-3 py-4 text-center text-gray-500">Belum ada pengguna yang terdaftar.</td>
                        </tr>
                        @else
                        @foreach ($users as $user)
                        <tr class="hover:bg-blue-50/50">
                            {{-- GAMBAR --}}
                            <td class="px-3 py-4 whitespace-nowrap">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url ?? asset('img/default-avatar.png') }}" alt="{{ $user->name }}">
                            </td>

                            {{-- NAMA LENGKAP --}}
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $user->name }}
                            </td>

                            {{-- EMAIL --}}
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->email }}
                            </td>

                            {{-- ROLE (IMPLEMENTASI Badge/Tag) --}}
                            <td class="px-3 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($user->role === 'admin') 
                                        bg-green-100 text-green-800 
                                    @else 
                                        bg-blue-100 text-blue-800 
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            {{-- AKSI (Detail, Edit, Hapus) --}}
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-purple-600 hover:text-purple-900 mr-3">Detail</a>
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <form action="#" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-4 flex justify-center">
                {{ $users->links() }}
            </div>
        </div> {{-- Close users-table-results --}}
    </div>

    @endsection