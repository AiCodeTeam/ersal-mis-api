<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Base URL for storage
        $baseUrl = config('app.url') . 'storage/';

        // Number of records to create
        $totalRecords = 50;

        for ($i = 1; $i <= $totalRecords; $i++) {
            // Reuse images (1.webp to 9.webp)
            $imageIndex = ($i % 9 == 0) ? 9 : $i % 9;
            $imageName = $imageIndex . '.webp';
            $imagePath = 'product-images/' . $imageName;

            // Check if the image exists in 'storage/app/public/product-images'
            if (Storage::disk('public')->exists($imagePath)) {
                Item::create([
                    'name' => 'Sample Item ' . $i,
                    'description' => 'This is the description for item ' . $i,
                    'date' => now()->subDays(rand(1, 30))->format('Y-m-d'), // Randomize date within last 30 days
                    'item_image' => $baseUrl . $imagePath,
                    'bill_image' => $baseUrl . $imagePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
