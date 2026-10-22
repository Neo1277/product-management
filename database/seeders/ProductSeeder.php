<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Keyboard',
                'sku' => 'KB-1001',
                'description' => 'Wireless keyboard with ergonomic design.',
                'price' => 49.99,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Mouse',
                'sku' => 'MS-1002',
                'description' => 'Wireless optical mouse with adjustable DPI.',
                'price' => 24.99,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'USB-C Hub',
                'sku' => 'HB-1003',
                'description' => 'USB-C hub with multiple connectivity ports.',
                'price' => 39.50,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Full HD Monitor',
                'sku' => 'MN-1004',
                'description' => '24-inch Full HD monitor for office use.',
                'price' => 179.99,
                'stock' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'sku' => 'KB-1005',
                'description' => 'Mechanical keyboard with RGB backlighting.',
                'price' => 89.99,
                'stock' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Laptop Stand',
                'sku' => 'LS-1006',
                'description' => 'Adjustable aluminum laptop stand.',
                'price' => 32.00,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Webcam HD',
                'sku' => 'WC-1007',
                'description' => 'HD webcam with built-in microphone.',
                'price' => 54.75,
                'stock' => 0,
                'is_active' => false,
            ],
            [
                'name' => 'Noise Cancelling Headphones',
                'sku' => 'HP-1008',
                'description' => 'Over-ear headphones with active noise cancellation.',
                'price' => 129.99,
                'stock' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'External SSD 1TB',
                'sku' => 'SD-1009',
                'description' => 'Portable solid-state drive with 1TB capacity.',
                'price' => 99.99,
                'stock' => 18,
                'is_active' => true,
            ],
            [
                'name' => 'USB-C Charging Cable',
                'sku' => 'CB-1010',
                'description' => 'Durable USB-C cable for charging and data transfer.',
                'price' => 12.99,
                'stock' => 50,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }
    }
}
