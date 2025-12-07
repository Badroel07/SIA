<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // <-- Pastikan model User diimport
use Illuminate\Support\Facades\Hash; // <-- Untuk hashing password
// use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query dasar untuk mengambil data User
        $query = User::query();

        // 2. Logika Pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
        }

        // 3. Logika Filter Role
        if ($request->filled('role')) {
            $roleFilter = $request->input('role');
            $query->where('role', $roleFilter);
        }

        // 4. Ambil data User dengan pagination (10 item per halaman)
        // Gunakan withQueryString() untuk mempertahankan parameter URL saat pagination
        $users = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        // 5. Ambil daftar role unik dari tabel users
        // Menggunakan select('role')->distinct() untuk mendapatkan nilai role unik saja.
        // pluck('role') mengubah hasil menjadi array sederhana.
        $roles = User::select('role')
            ->distinct()
            ->pluck('role');

        // 6. Lewatkan $users DAN $roles ke view
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
