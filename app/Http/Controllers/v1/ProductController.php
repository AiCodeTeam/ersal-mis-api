<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileHandling;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  use FileHandling;
    public function index(Request $request)
    {
        return Product::with(['images','category'])->paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);

    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Create the product
        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'product_category_id' => $request->input('product_category_id'),
        ]);
    
        // Handle image uploads using the uploadFiles method
        if ($request->hasFile('images')) {
            $uploadedPaths = $this->uploadFiles($request->file('images'), 'product-images');
    
            // Save each uploaded path to the database
            foreach ($uploadedPaths as $path) {
                $product->images()->create([
                    'image_url' => $path,
                ]);
            }
        }
        if($request->has('items')) {
            $product->items()->sync($request->input('items'));
        }
    
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully with images and category',
            'status' => 201,
            'data' => $product->load('images', 'category'),
        ], 201);
    }
    

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Load the 'images' and 'category' relationships
        $product->load(['images', 'category']);
    
        return response()->json([
            'success' => true,
            'message' => 'Product retrieved successfully',
            'data' => $product,
        ], 200);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update([
            'name' => $request->input('name', $product->name),
            'price' => $request->input('price', $product->price),
            'product_category_id' => $request->input('product_category_id', $product->product_category_id),
            'quantity' => $request->input('quantity', $product->quantity),
            'description' => $request->input('description', $product->description),
        ]);
    
        // Handle image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($product->images as $image) {
                $relativePath = str_replace(config('app.url') . 'storage/', '', $image->image_url);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
                $image->delete(); // Remove old image record from DB
            }
    
            // Upload new images
            $uploadedPaths = $this->uploadFiles($request->file('images'), 'product-images');
    
            // Save new images to the database
            foreach ($uploadedPaths as $path) {
                $product->images()->create([
                    'image_url' => $path,
                ]);
            }
        }
    
        // Update related items (sync with items array from the request)
        if ($request->has('items')) {
            $product->items()->sync($request->input('items'));
        }
    
        // Reload the product with its relationships
        $product->load('images', 'category', 'items');
    
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully with updated images and items',
            'status' => 200,
            'data' => $product,
        ], 200);
    }
    


    /**
     * Remove the specified product from storage.
     */
    public function destroy($productId)
    {
        // Find the product by ID
        $product = Product::find($productId);

        // Check if the product exists
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!',
            ], 404); // Return 404 if product is not found
        }

        // Perform soft delete
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product is deleted successfully',
        ], 200);
    }
}
