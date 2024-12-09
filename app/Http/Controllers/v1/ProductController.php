<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('images')->get();
        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products,
        ], 200);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product is stored successfully',
            'status' => 201,
            'data' => $product,
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
