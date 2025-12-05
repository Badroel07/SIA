<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menghitung dan menampilkan statistik utama untuk dashboard admin.
     */
    public function index()
    {

        $totalInitialStock = 1200;
        // 1. Total Stok Obat (Jumlah semua unit)
        $totalStock = Medicine::sum('stock');

        // 2. Total Produk Tersedia (Jumlah jenis obat yang memiliki stok > 0)
        $availableProducts = Medicine::where('stock', '>', 0)->count();

        // 3. Total Produk (Semua jenis obat)
        $totalProducts = Medicine::count();

        // 4. Total Terjual (Simulasi: Total Initial Mock - Total Stock Sekarang)
        // Logika ini hanya bersifat simulasi karena tidak ada tabel Sales.
        $totalSold = Medicine::sum('total_sold');

        // Data 5 obat dengan stok paling sedikit (peringatan)
        $lowStockMedicines = Medicine::where('stock', '<', 10)->orderBy('stock', 'asc')->take(5)->get();


        $stats = [
            'totalStock' => number_format($totalStock, 0, ',', '.'),
            'availableProducts' => $availableProducts . ' / ' . $totalProducts,
            'totalSold' => number_format($totalSold, 0, ',', '.'),
            'stockPercentage' => round(($totalStock / $totalInitialStock) * 100, 1),
        ];

        return view('admin.index', compact('stats', 'lowStockMedicines'));
    }
}
