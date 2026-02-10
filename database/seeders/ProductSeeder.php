<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product1 = Product::create(
            ['id' => 1, 'slug' => 'boxes','name' => 'boxes', 'quantity' => 100, 'price' => 100]  
        );
         $product2 = Product::create(
            ['id' => 2, 'slug' => 'pens','name' => 'pens', 'quantity' => 100, 'price' => 100]
        );
    }
}
