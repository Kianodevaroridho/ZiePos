<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan', 'slug' => 'makanan', 'description' => 'Berbagai jenis makanan'],
            ['name' => 'Minuman', 'slug' => 'minuman', 'description' => 'Berbagai jenis minuman'],
            ['name' => 'Snack', 'slug' => 'snack', 'description' => 'Berbagai jenis snack dan camilan'],
            ['name' => 'Kebutuhan Pokok', 'slug' => 'kebutuhan-pokok', 'description' => 'Kebutuhan sehari-hari'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'description' => 'Produk lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
