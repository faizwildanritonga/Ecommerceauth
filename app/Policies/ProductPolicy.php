<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

/**
 * Catatan: requirement menyebutnya "PostPolicy", tapi karena task ini
 * e-commerce (bukan blog) dan tidak ada model Post, policy ini dipakai
 * untuk model Product — otorisasi edit/delete sesuai requirement #7.
 */
class ProductPolicy
{
    // Semua role boleh lihat produk
    public function view(?User $user, Product $product): bool
    {
        return true;
    }

    // Hanya admin & editor yang boleh membuat produk
    public function create(User $user): bool
    {
        return $user->hasRole('admin', 'editor');
    }

    // Hanya admin & editor yang boleh edit produk
    public function update(User $user, Product $product): bool
    {
        return $user->hasRole('admin', 'editor');
    }

    // Hanya admin yang boleh hapus produk
    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole('admin');
    }
}
