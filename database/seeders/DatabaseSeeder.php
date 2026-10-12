<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Akun untuk testing multi-role (requirement #6 & #8) ----------
        User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@tugasweb.test',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        User::factory()->create([
            'name'     => 'Editor',
            'email'    => 'editor@tugasweb.test',
            'password' => bcrypt('password'),
            'role'     => 'editor',
        ]);

        User::factory()->create([
            'name'     => 'User Biasa',
            'email'    => 'user@tugasweb.test',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        // ---------- Kategori (8 kategori tetap) ----------
        $kategoriNama = [
            'Elektronik', 'Fashion Pria', 'Fashion Wanita', 'Perlengkapan Rumah',
            'Olahraga', 'Kecantikan', 'Buku', 'Mainan Anak',
        ];

        $kategoriList = collect($kategoriNama)->map(fn ($nama) => Category::create([
            'nama' => $nama,
            'slug' => \Illuminate\Support\Str::slug($nama),
        ]));

        // ---------- 60 produk realistis, tersebar di 8 kategori ----------
        Product::factory()
            ->count(60)
            ->state(fn () => ['category_id' => $kategoriList->random()->id])
            ->create();
    }
}
