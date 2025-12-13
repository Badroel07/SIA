<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CrudMedicineController extends Controller
{
    /**
     * Menampilkan daftar semua obat dengan fitur pencarian dan filter (INDEX).
     * Dipanggil oleh route admin.medicines.index atau admin.dashboard
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Medicine::query();

        // Logika Pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
        }

        // Logika Filter Kategori
        if ($request->filled('category')) {
            $categoryFilter = $request->input('category');

            // Hanya terapkan filter jika nilainya BUKAN 'all'
            if ($categoryFilter !== 'all') {
                $query->where('category', $categoryFilter);
            }
        }
        // --- AKHIR PERUBAHAN ---

        // Ambil data (15 item per halaman)
        $medicines = $query->orderBy('name', 'asc')->paginate(15)->withQueryString();

        // Ambil semua kategori unik untuk filter dropdown
        $categories = Medicine::select('category')->distinct()->pluck('category');

        $existingCategories = Medicine::select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();

        // Pastikan view CRUD index dipanggil
        return view('admin.medicine.index', compact('medicines', 'categories', 'existingCategories'));
    }

    public function create()
    {
        // Ambil semua kategori unik, sama seperti di index
        $existingCategories = Medicine::distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();

        // Render view create.blade.php dengan variabel yang dibutuhkan
        return view('admin.medicine.create', compact('existingCategories'));
    }

    /**
     * Menampilkan formulir untuk membuat data obat baru (CREATE).
     * Dipanggil oleh route admin.medicines.create
     */

    /**
     * Menyimpan data obat baru (termasuk upload gambar) (STORE).
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (tetap sama)
        $request->validate([
            'name' => 'required|string|max:100|unique:medicines,name',
            'category' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'full_indication' => 'required|string',
            'usage_detail' => 'required|string',
            'side_effects' => 'required|string',
            'contraindications' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('medicines', 'public');
        }

        $slug = Str::slug($request->name);

        Medicine::create([
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'full_indication' => $request->full_indication,
            'usage_detail' => $request->usage_detail,
            'side_effects' => $request->side_effects,
            'contraindications' => $request->contraindications,
            'image' => $imagePath,
            'total_sold' => 0,
        ]);

        // PERBAIKAN: Menggunakan route admin.medicines.index
        return redirect()->route('admin.medicines.index')->with('success', 'Data obat berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir untuk mengedit data obat dan mengelola stok (EDIT).
     */
    // public function edit(Medicine $medicine)
    // {
    //     $existingCategories = Medicine::select('category')
    //         ->distinct()
    //         ->pluck('category')
    //         ->filter()
    //         ->values()
    //         ->toArray();
    //     return view('admin.medicine.edit', compact('medicine', 'existingCategories'));
    // }

    /**
     * Memperbarui data obat dan stok (UPDATE).
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:medicines,name,' . $medicine->id,
            'category' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'stock_adjustment' => 'nullable|integer', // Kolom untuk menambah/mengurangi stok
            'stock_reason' => 'required_if:stock_adjustment,<,0|string|in:sold,other', // Validasi untuk alasan pengurangan stok
            'description' => 'required|string',
            'full_indication' => 'required|string',
            'usage_detail' => 'required|string',
            'side_effects' => 'required|string',
            'contraindications' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'stock_adjustment', 'image', 'stock_reason']);
        $originalStock = $medicine->stock;

        if ($request->filled('stock_adjustment')) {
            $adjustment = (int) $request->stock_adjustment;
            $data['stock'] = $originalStock + $adjustment;

            // Logika baru untuk pengurangan stok
            if ($adjustment < 0) {
                // Hanya tambahkan total_sold jika alasan adalah "terjual"
                if ($request->stock_reason === 'sold') {
                    $soldUnits = abs($adjustment);
                    $data['total_sold'] = $medicine->total_sold + $soldUnits;
                }
            }

            if ($data['stock'] < 0) {
                return redirect()->back()->with('error', 'Stok yang dikurangi melebihi stok tersedia!');
            }
        }

        if ($request->hasFile('image')) {
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Data obat berhasil diperbarui!');
    }
    /**
     * Menghapus data obat (DELETE).
     */
    public function destroy(Medicine $medicine)
    {
        // Hapus file gambar lama jika ada
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }

        $medicine->delete();

        // PERBAIKAN: Menggunakan route admin.medicines.index
        return redirect()->route('admin.medicines.index')->with('success', 'Data obat berhasil dihapus!');
    }

    public function detail($id)
    {
        $medicine = Medicine::findOrFail($id);

        // 1. Hitung URL di sisi server (PHP)
        $imageUrl = $medicine->image
            ? Storage::disk('public')->url($medicine->image)
            : null;

        return response()->json([
            'id' => $medicine->id,
            'name' => $medicine->name,
            'category' => $medicine->category,
            'price' => $medicine->price,
            'stock' => $medicine->stock,
            'total_sold' => $medicine->total_sold ?? 0,
            'image' => $imageUrl,
            // 'image' => $medicine->image,
            'description' => $medicine->description,
            'full_indication' => $medicine->full_indication,
            'usage_detail' => $medicine->usage_detail,
            'side_effects' => $medicine->side_effects,
            'contraindications' => $medicine->contraindications,
        ]);
    }
}
