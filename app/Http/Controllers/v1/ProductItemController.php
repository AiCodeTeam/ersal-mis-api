<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductItemRequest;
use App\Http\Requests\UpdateProductItemRequest;
use App\Models\ProductItem;
use Illuminate\Http\Request;

class ProductItemController extends Controller
{

    public function index()
    {
        $productItems = ProductItem::all();

        return response()->json([
            'success' => true,
            'message' => 'Product items retrieved successfully',
            'status' => 200,
            'data' => $productItems,
        ], 200);
    }

    /**
     * Store a newly created product item in storage.
     */
    public function store(StoreProductItemRequest $request)
    {
        $productItem = ProductItem::create([
            'product_id' => $request->input('product_id'),
            'item_id' => $request->input('item_id'),
            'quantity' => $request->input('quantity'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product item stored successfully',
            'status' => 201,
            'data' => $productItem,
        ], 201);
    }

    /**
     * Display the specified product item.
     */
    public function show($id)
    {
        // Find the ProductItem by id
        $productItem = ProductItem::find($id);

        // If not found, return a custom error message
        if (!$productItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product item not found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product item retrieved successfully',
            'status' => 200,
            'data' => $productItem,
        ], 200);
    }

    /**
     * Update the specified product item in storage.
     */
    public function update(UpdateProductItemRequest $request, ProductItem $productItem)
    {
        $productItem->update([
            'product_id' => $request->input('product_id'),
            'item_id' => $request->input('item_id'),
            'quantity' => $request->input('quantity'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product item updated successfully',
            'status' => 200,
            'data' => $productItem,
        ], 200);
    }

    /**
     * Remove the specified product item from storage.
     */
    public function destroy($id)
    {
        // Find the ProductItem by id
        $productItem = ProductItem::find($id);

        // If not found, return a custom error message
        if (!$productItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product item not found',
                'status' => 404,
            ], 404);
        }

        // Delete the product item
        $productItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product item deleted successfully',
            'status' => 200,
        ], 200);
    }
}
