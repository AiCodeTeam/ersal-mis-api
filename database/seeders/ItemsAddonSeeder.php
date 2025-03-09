<?php

namespace Database\Seeders;

use App\Models\ItemsAddon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ItemsAddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $baseUrl = config('app.url') . 'storage/';
        $totalRecords = 50;

        for ($i = 1; $i <= $totalRecords; $i++) {
            $imageIndex = ($i % 9 == 0) ? 9 : $i % 9;
            $imageName = $imageIndex . '.webp';
            $imagePath = 'product-images/' . $imageName;

            $billImage = null;
            if (Storage::disk('public')->exists($imagePath)) {
                $billImage = $baseUrl . $imagePath;
            }

            ItemsAddon::create([
                'item_id' => rand(1, 40),
                'description' => 'Addon Description ' . $i,
                'price_usd' => rand(10, 500),
                'price_afg' => rand(800, 40000),
                'quantity' => rand(1, 100),
                'date' => now()->subDays(rand(0, 365))->toDateString(),
                'bill_image' => $billImage,
            ]);
        }
    }
}