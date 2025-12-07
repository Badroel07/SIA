<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Session;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

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

    public function processPayment(Request $request)
    {
        // Validasi input
        $request->validate([
            'invoice_number' => 'required|string|unique:transactions,invoice_number',
            'total_amount' => 'required|numeric|min:0'
        ]);

        // Mulai Database Transaction
        DB::beginTransaction();
        try {
            $invoiceNumber = $request->input('invoice_number');
            $totalAmount = $request->input('total_amount');
            $cartItems = Session::get('cart', []);

            if (empty($cartItems)) {
                DB::rollBack();
                return redirect()->route('cashier.transaction.index')->with('error', 'Keranjang belanja kosong, tidak dapat memproses pembayaran.');
            }

            // 1. SIMPAN DATA TRANSAKSI UTAMA ke tabel 'transactions'
            $transaction = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'total_amount' => $totalAmount,
                'user_id' => auth()->id(),
                'transaction_date' => now(),
                'status' => 'completed'
            ]);

            // 2. LOOPING SETIAP ITEM DI KERANJANG
            foreach ($cartItems as $item) {
                // 2a. SIMPAN DETAIL TRANSAKSI ke tabel 'transaction_details'
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'medicine_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);

                // --- PERBAIKAN: Gabungkan semua logika update obat di dalam loop ---
                $medicine = Medicine::find($item['id']);
                if ($medicine) {
                    // Cek stok sebagai pengaman
                    if ($medicine->stock < $item['quantity']) {
                        throw new \Exception('Stok obat "' . $medicine->name . '" tidak mencukupi.');
                    }

                    // Kurangi stok
                    $medicine->stock -= $item['quantity'];
                    // Tambah total terjual
                    $medicine->total_sold += $item['quantity'];
                    // Simpan perubahan SEKALI saja untuk setiap item
                    $medicine->save();
                }
            } // <-- Akhir dari loop. Semua item sudah diproses.

            // HAPUS blok kode yang mengupdate obat yang berada di luar loop.

            // Jika semua proses di atas berhasil, maka commit transaksi
            DB::commit();

            // 3. KOSONGKAN KERANJANG BELANJA
            Session::forget('cart');

            // 4. REDIRECT KE HALAMAN TRANSAKSI DENGAN PESAN SUKSES
            return redirect()->route('cashier.transaction.index')->with('success', 'Pembayaran berhasil! Nomor invoice: ' . $invoiceNumber);
        } catch (\Exception $e) {
            // Jika terjadi error di manapun dalam blok try, lakukan rollback
            DB::rollBack();

            // Log error untuk debugging
            \Log::error('Payment processing failed: ' . $e->getMessage());

            // Redirect dengan pesan error
            return redirect()->route('cashier.transaction.index')->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function history(Request $request)
    {
        // Query untuk mengambil transaksi dengan relasi user (kasir)
        // dan diurutkan dari yang terbaru.
        $query = Transaction::with('user')->latest();

        // Logika Pencarian berdasarkan Nomor Invoice
        if ($request->has('search') && !empty($request->search)) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        // Ambil data dengan pagination (10 data per halaman)
        $transactions = $query->paginate(10);

        // Kembalikan view dengan data transaksi
        return view('cashier.transaction.history', compact('transactions'));
    }

    /**
     * Mengambil detail transaksi tertentu untuk ditampilkan di modal.
     * Method ini dipanggil via JavaScript (AJAX).
     */
    public function showDetails($id)
    {
        // SESUDAH (BENAR - dengan eager loading)
        $transaction = Transaction::with(['user', 'details.medicine'])->find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaction);
    }
}
