<?php

use Illuminate\Support\Facades\Route;

// =========================================================================================
// 1. IMPORTS (Pastikan Anda mengimpor Controller ini)
// =========================================================================================
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Admin\CrudMedicineController; // Controller CRUD Obat
use App\Http\Controllers\Admin\DashboardController; // Controller Dashboard

// =========================================================================================
// 2. PUBLIC / CUSTOMER ROUTES
// =========================================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/medicine_detail/{slug}', [HomeController::class, 'show'])->name('show');
Route::get('/about', [HomeController::class, 'about'])->name('about');


// =========================================================================================
// 3. ADMIN ROUTES (Prefix: /admin)
// =========================================================================================
Route::prefix('admin')
    // Hapus middleware(['auth', 'admin']) sementara untuk development cepat
    ->name('admin.')
    ->group(function () {

        // Rute Dasar Admin (admin.dashboard) -> Menampilkan Statistik
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('medicines/{id}/detail', [CrudMedicineController::class, 'detail']);
        // Route::get('medicines/create', [CrudMedicineController::class, 'create'])->name('medicines.create');
        // Route::get('medicines/{id}/edit', [CrudMedicineController::class, 'edit'])->name('medicines.edit');


        Route::resource('medicines', CrudMedicineController::class)->except(['show', 'edit']);
    });


// =========================================================================================
// 4. CASHIER ROUTES
// =========================================================================================
Route::prefix('cashier')
    // Hapus middleware(['auth', 'cashier']) sementara
    ->name('cashier.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

// require __DIR__.'/auth.php';