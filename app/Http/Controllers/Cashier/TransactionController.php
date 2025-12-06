<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
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
        return view('cashier.transaction.index', compact('medicines', 'categories', 'existingCategories'));
    }

    public function cartAdd(Request $request)
    {
        // 1. VALIDASI DATA INPUT
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $medicineId = $request->input('medicine_id');
        $quantity = (int) $request->input('quantity');

        // 2. AMBIL DATA OBAT
        $medicine = Medicine::find($medicineId);

        // Cek stok (Penting!)
        if ($quantity > $medicine->stock) {
            return redirect()->route('cashier.transaction.index')->with('error', 'Kuantitas melebihi stok yang tersedia.');
        }

        // 3. KELOLA KERANJANG DI SESSION
        $cart = Session::get('cart', []);

        // Format data item untuk Session
        $newItem = [
            'id' => $medicine->id,
            'name' => $medicine->name,
            'price' => $medicine->price,
            'quantity' => $quantity,
            'subtotal' => $medicine->price * $quantity,
        ];

        // 4. CEK APAKAH OBAT SUDAH ADA DI KERANJANG
        if (isset($cart[$medicineId])) {
            // Jika sudah ada, tambahkan kuantitasnya
            $currentQuantity = $cart[$medicineId]['quantity'];
            $newTotalQuantity = $currentQuantity + $quantity;

            // Cek stok lagi setelah penambahan (opsional, tapi baik)
            if ($newTotalQuantity > $medicine->stock) {
                return redirect()->route('cashier.transaction.index')->with('error', 'Total kuantitas item ' . $medicine->name . ' melebihi stok!');
            }

            // Update kuantitas dan subtotal
            $cart[$medicineId]['quantity'] = $newTotalQuantity;
            $cart[$medicineId]['subtotal'] = $medicine->price * $newTotalQuantity;
        } else {
            // Jika belum ada, tambahkan item baru
            $cart[$medicineId] = $newItem;
        }

        // 5. SIMPAN KEMBALI KERANJANG KE SESSION
        Session::put('cart', $cart);

        // 6. REDIRECT DAN BERI NOTIFIKASI
        return redirect()->route('cashier.transaction.index')->with('success', $medicine->name . ' berhasil ditambahkan ke keranjang!');
    }

    public function cartClear()
    {
        // Hapus key 'cart' dari Session
        Session::forget('cart');

        // Redirect kembali ke halaman transaksi dengan notifikasi
        return redirect()->route('cashier.transaction.index')->with('success', 'Keranjang belanja berhasil dikosongkan.');
    }
}
