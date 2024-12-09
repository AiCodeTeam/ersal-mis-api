<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
   
    public function run()
    {
        // Insert 50 records manually
        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'name' => 'Product ' . ($i + 1),
                'price' => rand(100, 1000), // Random price between 100 and 1000
                'product_category_id' => rand(1, 10), // Random category_id between 1 and 10
                'quantity' => rand(1, 100), // Random quantity between 1 and 100
                'description' => 'This is product ' . ($i + 1), // Example description
            ]);
        }
    }
}
