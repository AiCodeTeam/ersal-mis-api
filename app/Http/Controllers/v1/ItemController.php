<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Traits\FileHandling;
use App\Models\Product;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use FileHandling;
    public function index(Request $request)
    {

        $items = Item::with(['itemAddons', 'products'])->paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);

        return response()->json([
            'success' => true,
            'message' => 'Items retrieved successfully',
            'status' => 200,
            'data' => $items,
        ], 200);
    }

    public function show(Item $item, Request $request)
    {
        // Check if the item exists
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found!',
                'status' => 404,
                'data' => null,
            ], 404);
        }
    
        // Eager load the relationships: products and paginated itemAddons
        $item->load('products'); // Eager load products
        $itemAddons = $item->itemAddons()->paginate($request->input('per_page', 10)); // Paginate itemAddons
    
        // Include the relationships in the response
        return response()->json([
            'success' => true,
            'message' => 'Item retrieved successfully',
            'status' => 200,
            'data' => [
                'item' => $item,
                'products' => $item->products, // Loaded products relationship
                'item_addons' => $itemAddons, // Paginated result for itemAddons
            ],
        ], 200);
    }
    

    // public function show(Item $item)
    // {
    //     $item->load(['itemAddons']);
    //     if (!$item) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Item not found!',
    //             'status' => 404,
    //             'data' => $item,
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Item retrieved successfully',
    //         'status' => 200,
    //         'data' => $item,
    //     ], 200);
    // }


    /**
     * Store a newly created item in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $itemImagePath = null;

        // Upload 'item_image' if it exists
        if ($request->hasFile('item_image')) {
            $itemImagePath = $this->uploadFile(
                $request->file('item_image'),
                null,
                'items/images'
            );
        }

        $item = Item::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'item_image' => $itemImagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Item stored successfully',
            'status' => 201,
            'data' => $item,
        ], 201);
    }

    /**
     * Display the specified item.
     */

    /**
     * Update the specified item in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $itemImagePath = $item->item_image;
        // $billImagePath = $item->bill_image;

        // Update 'item_image' if it exists
        if ($request->hasFile('item_image')) {
            $itemImagePath = $this->uploadFile(
                $request->file('item_image'),
                $item->item_image,
                'items/images'
            );
        }

    

        $item->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'item_image' => $itemImagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully',
            'status' => 200,
            'data' => $item,
        ], 200);
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Item $item)
    {
        // Delete related images
        if ($item->item_image) {
            $this->deleteFile($item->item_image);
        }
        if ($item->bill_image) {
            $this->deleteFile($item->bill_image);
        }
        $item->delete();
        return response()->json([
            'success' => true,
            'message' => 'Item images deleted successfully',
            'status' => 200,
        ], 200);
    }
}
