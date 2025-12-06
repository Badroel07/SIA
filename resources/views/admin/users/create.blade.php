@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="flex items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Pengguna Baru</h1>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-white shadow-xl rounded-xl p-6 sm:p-8 max-w-2xl mx-auto">

        {{-- Formulir akan diproses oleh method 'store' di UserController --}}
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            {{-- 1. Input NAMA LENGKAP --}}
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 2. Input EMAIL --}}
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}" placeholder="Masukkan alamat email">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3. Input PASSWORD --}}
            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                    placeholder="Masukkan password">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 4. Input KONFIRMASI PASSWORD --}}
            <div class="mb-5">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ulangi password">
            </div>

            {{-- 5. Input ROLE --}}
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" id="role" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror">
                    <option value="" disabled selected>Pilih Role Pengguna</option>
                    @foreach ($availableRoles as $role)
                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                    @endforeach
                </select>
                @error('role')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-150">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                    Simpan Pengguna
                </button>
            </div>
        </form>

    </div>
</div>
@endsection