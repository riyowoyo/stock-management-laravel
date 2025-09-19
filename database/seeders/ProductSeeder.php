<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_code' => 'LF001',
                'name' => 'Lem Fox 20ml',
                'unit' => 'pcs',
                'price' => 2500,
                'stock' => 100,
            ],
            [
                'product_code' => 'LF002',
                'name' => 'Lem Fox 50ml',
                'unit' => 'pcs',
                'price' => 5000,
                'stock' => 50,
            ],
            [
                'product_code' => 'LF003',
                'name' => 'Lem Fox Cair 100ml',
                'unit' => 'pcs',
                'price' => 12000,
                'stock' => 30,
            ],
            [
                'product_code' => 'LF004',
                'name' => 'Lem Fox Cair 250ml',
                'unit' => 'pcs',
                'price' => 25000,
                'stock' => 20,
            ],
            [
                'product_code' => 'LF005',
                'name' => 'Lem Fox Batangan 50g',
                'unit' => 'pcs',
                'price' => 7000,
                'stock' => 40,
            ],
            [
                'product_code' => 'LF006',
                'name' => 'Lem Fox Batangan 100g',
                'unit' => 'pcs',
                'price' => 12000,
                'stock' => 25,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
