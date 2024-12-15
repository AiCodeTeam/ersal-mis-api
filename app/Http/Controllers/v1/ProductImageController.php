<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Traits\FileHandling;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    use FileHandling;

    public function index()
    { 
        return ProductImage::paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);
    }

    /**
     * Store a newly created product image in storage.
     */
    public function store(StoreProductImageRequest $request)
    {
        // Check if files are provided
        if ($request->hasFile('image_url') && is_array($request->file('image_url'))) {
            // Use the uploadFiles method from the FileHandling trait
            $uploadedPaths = $this->uploadFiles($request->file('image_url'), 'product-images');
            $productImages = [];

            // Save each uploaded file in the database
            foreach ($uploadedPaths as $path) {
                $productImages[] = ProductImage::create([
                    'product_id' => $request->input('product_id'),
                    'image_url' => $path,
                    'description' => $request->input('description'),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product images stored successfully',
                'status' => 201,
                'data' => $productImages,
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'No images provided',
            'status' => 400,
        ], 400);
    }

    /**
     * Display the specified product image.
     */
    public function show(ProductImage $productsImage)
    {
        return response()->json([
            'success' => true,
            'message' => 'Product image retrieved successfully',
            'status' => 200,
            'data' => $productsImage,
        ], 200);
    }

    /**
     * Update the specified product image in storage.
     */
    public function update(UpdateProductImageRequest $request, ProductImage $productsImage)
    {
        // Update fields only if they are provided in the request
        $fillableFields = ['product_id', 'description'];

        foreach ($fillableFields as $field) {
            if ($request->filled($field)) {
                $productsImage->$field = $request->input($field);
            }
        }

        // Save the updated model
        $productsImage->save();

        return response()->json([
            'success' => true,
            'message' => 'Product image updated successfully',
            'status' => 200,
            'data' => $productsImage,
        ], 200);

        // // Upload new images if provided
        // if ($request->hasFile('images')) {
        //     // Delete the old image if it exists
        //     if ($productsImage->image_url) {
        //         $this->deleteFile($productsImage->image_url);
        //     }

        //     // Upload new files and store their URLs in the database
        //     $uploadedPaths = $this->uploadFiles($request->file('images'), 'product-images');
        //     foreach ($uploadedPaths as $path) {
        //         // Create new records for each image
        //         ProductImage::create([
        //             'product_id' => $productsImage->product_id,
        //             'image_url' => $path,
        //             'description' => $productsImage->description,
        //         ]);
        //     }
        // }


    }

    /**
     * Remove the specified product image from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        // Delete the product image file from storage
        Storage::delete('public/product-images/' . $productImage->product_image);

        // Delete the product image record from the database
        $productImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product image deleted successfully',
            'status' => 200,
        ], 200);
    }
}
