<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $nama = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'nama'        => Str::title($nama),
            'slug'        => Str::slug($nama) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'deskripsi'   => fake()->paragraph(3),
            'harga'       => fake()->numberBetween(15, 2500) * 1000, // Rp 15.000 - Rp 2.500.000
            'stok'        => fake()->numberBetween(0, 150),
        ];
    }
}
