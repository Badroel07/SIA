<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\MedicineController;
use App\Http\Controllers\User\HomeController;

// Halaman Katalog Utama
Route::get('/', [MedicineController::class, 'index'])->name('home');

// Halaman Detail Obat
Route::get('/obat/{slug}', [MedicineController::class, 'show'])->name('show');

Route::get('/about', [HomeController::class, 'about'])->name('about')->middleware('about');
