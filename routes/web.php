<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Storage;

// =========================================================================================
// 1. IMPORTS (Pastikan Anda mengimpor Controller ini)
// =========================================================================================
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Admin\CrudMedicineController; // Controller CRUD Obat
use App\Http\Controllers\Admin\DashboardController; // Controller Dashboard
use App\Http\Controllers\Admin\UserController; // Controller Dashboard
use App\Http\Controllers\Cashier\DashboardCashierController; // Controller Dashboard
use App\Http\Controllers\Cashier\TransactionController;
use App\Http\Controllers\AuthController; // JANGAN LUPA IMPORT INI

// ---- AUTHENTICATION ROUTES ----
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// ------------------------------

// =========================================================================================
// 2. PUBLIC / CUSTOMER ROUTES
// =========================================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/medicine_detail/{slug}', [HomeController::class, 'show'])->name('show');
Route::get('/about', [HomeController::class, 'about'])->name('about');


// =========================================================================================
// 3. ADMIN ROUTES (Prefix: /admin)
// =========================================================================================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Rute Dasar Admin (admin.dashboard) -> Menampilkan Statistik
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('medicines/{id}/detail', [CrudMedicineController::class, 'detail']);

    Route::get('/users', [UserController::class, 'index'])->name('users.index'); // Halaman Daftar
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // Halaman Form
    Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Proses Form

    Route::resource('medicines', CrudMedicineController::class)->except(['show', 'edit']);

    // routes/web.php
    // Tampilkan Form

});


// =========================================================================================
// 4. CASHIER ROUTES
// =========================================================================================
// routes/web.php

// Bungkus semua route kasir Anda dalam group middleware ini
Route::middleware(['auth', 'is_cashier'])->prefix('cashier')->name('cashier.')->group(function () {


    Route::get('/', [DashboardCashierController::class, 'index'])->name('dashboard');

    // Route untuk Halaman Utama Transaksi Kasir
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');

    // Route untuk Tambah Item ke Keranjang
    Route::post('/transaction/cart/add', [TransactionController::class, 'cartAdd'])->name('transaction.cartAdd');

    // Route untuk Batalkan/Kosongkan Keranjang
    Route::post('/transaction/cart/clear', [TransactionController::class, 'cartClear'])->name('transaction.cartClear');

    // Route PENTING: Untuk Menyelesaikan Pembayaran dan Simpan ke DB
    Route::post('/transaction/complete', [TransactionController::class, 'completeTransaction'])->name('transaction.complete');

    Route::get('transaction/medicines/{id}/detail', [CrudMedicineController::class, 'detail'])->name('transaction.medicine.detail');

    // ... route kasir lainnya ...
});



// // require __DIR__.'/auth.php';

// Route::get('/tes-s3-upload', function () {
//     try {
//         $filename = 'tes-koneksi-' . time() . '.txt';
//         $content = 'Koneksi S3 berhasil! Waktu: ' . now();

//         // Upload
//         Storage::disk('s3')->put($filename, $content, 'public');

//         // BUAT URL MANUAL
//         $bucket = env('sia-chkl-laravel');
//         $region = env('ap-southeast-2');

//         $url = "https://{$bucket}.s3.{$region}.amazonaws.com/{$filename}";

//         return "✔️ Koneksi S3 Berhasil! File '$filename' telah diunggah ke: 
//             <a href='$url' target='_blank'>$url</a>";
//     } catch (\Exception $e) {
//         return "❌ Koneksi S3 Gagal: " . $e->getMessage();
//     }
// });
