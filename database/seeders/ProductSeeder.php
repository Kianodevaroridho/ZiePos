<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Makanan (category_id: 1)
            ['category_id' => 1, 'name' => 'Nasi Goreng', 'sku' => 'MKN-001', 'price' => 15000, 'stock' => 50, 'description' => 'Nasi goreng spesial'],
            ['category_id' => 1, 'name' => 'Mie Goreng', 'sku' => 'MKN-002', 'price' => 13000, 'stock' => 50, 'description' => 'Mie goreng pedas'],
            ['category_id' => 1, 'name' => 'Ayam Goreng', 'sku' => 'MKN-003', 'price' => 20000, 'stock' => 30, 'description' => 'Ayam goreng crispy'],
            ['category_id' => 1, 'name' => 'Sate Ayam', 'sku' => 'MKN-004', 'price' => 18000, 'stock' => 25, 'description' => 'Sate ayam 10 tusuk'],
            ['category_id' => 1, 'name' => 'Bakso', 'sku' => 'MKN-005', 'price' => 12000, 'stock' => 40, 'description' => 'Bakso sapi spesial'],

            // Minuman (category_id: 2)
            ['category_id' => 2, 'name' => 'Es Teh Manis', 'sku' => 'MNM-001', 'price' => 5000, 'stock' => 100, 'description' => 'Es teh manis segar'],
            ['category_id' => 2, 'name' => 'Es Jeruk', 'sku' => 'MNM-002', 'price' => 7000, 'stock' => 80, 'description' => 'Es jeruk peras'],
            ['category_id' => 2, 'name' => 'Kopi Hitam', 'sku' => 'MNM-003', 'price' => 8000, 'stock' => 60, 'description' => 'Kopi hitam tubruk'],
            ['category_id' => 2, 'name' => 'Jus Alpukat', 'sku' => 'MNM-004', 'price' => 12000, 'stock' => 30, 'description' => 'Jus alpukat segar'],
            ['category_id' => 2, 'name' => 'Air Mineral', 'sku' => 'MNM-005', 'price' => 4000, 'stock' => 200, 'description' => 'Air mineral 600ml'],

            // Snack (category_id: 3)
            ['category_id' => 3, 'name' => 'Keripik Singkong', 'sku' => 'SNK-001', 'price' => 10000, 'stock' => 45, 'description' => 'Keripik singkong renyah'],
            ['category_id' => 3, 'name' => 'Pisang Goreng', 'sku' => 'SNK-002', 'price' => 8000, 'stock' => 35, 'description' => 'Pisang goreng crispy'],
            ['category_id' => 3, 'name' => 'Tahu Crispy', 'sku' => 'SNK-003', 'price' => 6000, 'stock' => 50, 'description' => 'Tahu crispy pedas'],

            // Kebutuhan Pokok (category_id: 4)
            ['category_id' => 4, 'name' => 'Beras 5kg', 'sku' => 'KBP-001', 'price' => 65000, 'stock' => 20, 'description' => 'Beras premium 5kg'],
            ['category_id' => 4, 'name' => 'Minyak Goreng 1L', 'sku' => 'KBP-002', 'price' => 18000, 'stock' => 30, 'description' => 'Minyak goreng 1 Liter'],
            ['category_id' => 4, 'name' => 'Gula Pasir 1kg', 'sku' => 'KBP-003', 'price' => 14000, 'stock' => 40, 'description' => 'Gula pasir putih 1kg'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
