<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Loop through 9 images
        for ($i = 1; $i <= 9; $i++) {
            $imageName = $i . '.webp'; // Image name in format 1.webp, 2.webp, ..., 9.webp
            $imagePath = 'product-images/' . $imageName; // Assuming images are stored in the 'product-images' folder

            // Check if the image file exists
            if (Storage::exists($imagePath)) {
                // Get the base URL for storing the image
                $baseUrl = config('app.url');

                // Create ProductImage record
                ProductImage::create([
                    'product_id' => $i,  // Example: Assigning product_id same as the loop index
                    'image_url' => $baseUrl . '/storage/' . $imagePath, // Full URL to image
                    'description' => 'Image ' . $i, // Example description
                ]);
            }
        }
    }
}
