<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Halaman publik: semua orang (termasuk tamu) boleh lihat daftar produk
Route::get('/', [ProductController::class, 'index'])->name('products.index');

require __DIR__ . '/auth.php'; // disediakan otomatis oleh Breeze

// ---------- Area yang butuh login ----------
Route::middleware('auth')->group(function () {

    // Requirement #6: custom middleware 'role' -> hanya admin & editor
    Route::middleware('role:admin,editor')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    });

    // Requirement #7: hapus dicek lewat ProductPolicy (hanya admin),
    // bukan cuma lewat middleware, supaya ada 2 lapis otorisasi.
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
