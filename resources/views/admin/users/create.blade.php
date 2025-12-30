@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna Baru')

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

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-8px);
        }
    }

    .animate-slide-up {
        animation: slideInUp 0.5s ease-out forwards;
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
    }

    .input-modern {
        transition: all 0.3s ease;
    }

    .input-modern:focus {
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
    }

    /* Select2 Modern Styling - Admin Purple Theme */
    .select2-container--default .select2-selection--single {
        height: 56px !important;
        padding: 0.75rem 1rem !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 1rem !important;
        background: #f9fafb !important;
        transition: all 0.3s ease;
    }

    .select2-container--default .select2-selection--single:hover {
        border-color: #d1d5db !important;
        background: white !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #8b5cf6 !important;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15) !important;
        background: white !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 54px !important;
        top: 1px !important;
        right: 8px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #9ca3af transparent transparent transparent !important;
        border-width: 6px 5px 0 5px !important;
    }

    .select2-selection__rendered {
        line-height: 32px !important;
        color: #374151 !important;
        font-weight: 500 !important;
        padding-left: 0 !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 2px solid #e5e7eb !important;
        border-radius: 0.75rem !important;
        padding: 0.75rem 1rem !important;
        font-size: 1rem !important;
        transition: all 0.3s ease;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #8b5cf6 !important;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15) !important;
        outline: none;
    }

    .select2-dropdown {
        border-radius: 1rem !important;
        border: 2px solid #e5e7eb !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        overflow: hidden;
        margin-top: 4px !important;
    }

    .select2-results__option {
        padding: 0.75rem 1rem !important;
        font-weight: 500 !important;
        transition: all 0.2s ease;
    }

    .select2-results__option--highlighted {
        background: linear-gradient(to right, #8b5cf6, #6366f1) !important;
        color: white !important;
    }

    .select2-results__option--selected {
        background-color: #ede9fe !important;
        color: #5b21b6 !important;
    }
</style>

<div class="min-h-screen p-4 lg:p-8">

    <!-- Background Decorations -->
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-2xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center gap-4 animate-slide-up">
            <a href="{{ route('admin.users.index') }}" class="w-12 h-12 bg-white rounded-2xl shadow-lg flex items-center justify-center text-gray-600 hover:text-purple-600 hover:scale-110 transition-all duration-300">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-500/30">
                    <i class="fas fa-user-plus text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Tambah Pengguna</h1>
                    <p class="text-gray-500">Isi data pengguna baru di bawah ini</p>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="glass-card rounded-3xl shadow-2xl border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 0.1s;">

            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6">
                <div class="flex items-center gap-3 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-id-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Informasi Pengguna</h3>
                        <p class="text-purple-100 text-sm">Semua field wajib diisi</p>
                    </div>
                </div>
            </div>

            {{-- Form Content --}}
            <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 sm:p-8 space-y-6">
                @csrf

                {{-- Name Input --}}
                <div class="space-y-2">
                    <label for="name" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                        <i class="fas fa-user text-purple-500"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" name="name" id="name" required
                        class="input-modern w-full px-5 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:bg-white @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                    @error('name')
                    <p class="text-red-500 text-xs flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Input --}}
                <div class="space-y-2">
                    <label for="email" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                        <i class="fas fa-envelope text-purple-500"></i>
                        Email
                    </label>
                    <input type="email" name="email" id="email" required
                        class="input-modern w-full px-5 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:bg-white @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}" placeholder="contoh@email.com">
                    @error('email')
                    <p class="text-red-500 text-xs flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Input --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="password" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                            <i class="fas fa-lock text-purple-500"></i>
                            Password
                        </label>
                        <input type="password" name="password" id="password" required
                            class="input-modern w-full px-5 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:bg-white @error('password') border-red-500 @enderror"
                            placeholder="Buat password">
                        @error('password')
                        <p class="text-red-500 text-xs flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                            <i class="fas fa-lock text-purple-500"></i>
                            Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="input-modern w-full px-5 py-4 bg-gray-50 rounded-2xl border-2 border-gray-100 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:bg-white"
                            placeholder="Ulangi password">
                    </div>
                </div>

                {{-- Role Select --}}
                <div class="space-y-2">
                    <label for="role" class="flex items-center gap-2 text-sm font-bold text-gray-700">
                        <i class="fas fa-user-tag text-purple-500"></i>
                        Role Pengguna
                    </label>
                    <select name="role" id="role-select2" required class="w-full">
                        <option value="">Pilih Role Pengguna</option>
                        @foreach ($availableRoles as $role)
                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                        @endforeach
                    </select>
                    @error('role')
                    <p class="text-red-500 text-xs flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all duration-300">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 hover:scale-[1.02] transition-all duration-300">
                        <i class="fas fa-save"></i>
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#role-select2').select2({
            placeholder: "Pilih Role Pengguna",
            allowClear: false,
            minimumResultsForSearch: Infinity,
            width: '100%'
        });
    });
</script>
@endpush

@endsection