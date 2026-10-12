<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $nama = fake()->unique()->words(2, true);
        $nama = \Illuminate\Support\Str::title($nama);

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama),
        ];
    }
}
