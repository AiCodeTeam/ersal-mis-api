<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileHandling;

class ProductController extends Controller
{
  use FileHandling;
    public function index(Request $request)
    {
        return Product::with('images')->paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);

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
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'product_category_id' => $request->input('product_category_id', $product->product_category_id), // Keep old value if not provided
            'quantity' => $request->input('quantity'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product is updated successfully',
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
