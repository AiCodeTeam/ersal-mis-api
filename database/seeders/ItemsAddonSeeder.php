<?php

namespace Database\Seeders;

use App\Models\ItemsAddon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemsAddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            ItemsAddon::create([
                'item_id' => rand(1, 50), // Adjust range as per your Items table
                'description' => 'Addon Description ' . $i,
                'price_usd' => rand(10, 500),
                'price_afg' => rand(800, 40000),
                'quantity' => rand(1, 100),
                'date' => now()->subDays(rand(0, 365))->toDateString(),
            ]);
        }
    }
}
