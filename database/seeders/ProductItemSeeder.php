<?php

namespace Database\Seeders;

use App\Models\ProductItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert 50 records manually
        for ($i = 0; $i < 50; $i++) {
            ProductItem::create([
                'product_id' => rand(1, 50),
                'item_id' => rand(1, 50),   
                'quantity' => rand(1, 100),
            ]);
        }
    }
}
