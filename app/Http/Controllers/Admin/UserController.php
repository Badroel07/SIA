<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // <-- Pastikan model User diimport
use Illuminate\Support\Facades\Hash; // <-- Untuk hashing password
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // 1. Ambil data User untuk tabel utama (dengan pagination)
        $users = User::paginate(10);

        // 2. Ambil daftar role unik dari tabel users
        // Menggunakan select('role')->distinct() untuk mendapatkan nilai role unik saja.
        // pluck('role') mengubah hasil menjadi array sederhana.
        $roles = User::select('role')
            ->distinct()
            ->pluck('role');

        // 3. Lewatkan $users DAN $roles ke view
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        // Ambil daftar role yang tersedia dari Model User
        $availableRoles = User::getAvailableRoles();

        return view('admin.users.create', compact('availableRoles'));
    }

    public function store(Request $request)
    {
        // 1. Definisikan roles yang tersedia di satu tempat (Best Practice)
        $availableRoles = ['admin', 'cashier', 'customer'];

        // 2. Validasi Data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

            // PERBAIKAN: Gunakan aturan 'in' yang sesuai dengan daftar roles Anda
            'role' => 'required|in:' . implode(',', $availableRoles),
            // Hasilnya: 'required|in:admin,cashier,customer'
        ]);

        // 3. Simpan Data Baru ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', "Pengguna **{$user->name}** berhasil ditambahkan!");
    }
}
