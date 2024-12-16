<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::with(['itemAddons', 'products'])->paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);
    
        // Map the custom attribute into the paginated items
        $items->getCollection()->transform(function ($item) {
            $totalAddonQuantity = $item->itemAddons()->sum('quantity');
            $totalProductCount = $item->products()->count();
            // Add the custom calculated attribute
            $item->item_left = $totalAddonQuantity - $totalProductCount;
    
            return $item;
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Items retrieved successfully',
            'status' => 200,
            'data' => $items,
        ], 200);
    }
    
    public function show(Item $item)
    {
        if(!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found!',
                'status' => 404,
                'data' => $item,
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Item retrieved successfully',
            'status' => 200,
            'data' => $item,
        ], 200);
    }


    /**
     * Store a newly created item in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $item = Item::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
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
        $item->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
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
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully',
            'status' => 200,
        ], 200);
    }
}
