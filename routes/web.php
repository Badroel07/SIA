<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\MedicineController;
use App\Http\Controllers\Customer\HomeController;

// Halaman Katalog Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Detail Obat
Route::get('/obat/{slug}', [HomeController::class, 'show'])->name('show');

Route::get('/about', [HomeController::class, 'about'])->name('about')->middleware('about');
