<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemsAddonRequest;
use App\Http\Requests\UpdateItemsAddonRequest;
use App\Models\ItemsAddon;
use Illuminate\Http\Request;
use App\Traits\FileHandling;

class ItemsAddonController extends Controller
{
    use FileHandling;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ItemsAddon::with(['item'])->paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);
    }

    public function store(StoreItemsAddonRequest $request)
    {
        $billImagePath = null;
        // Upload 'bill_image' if it exists
        if ($request->hasFile('bill_image')) {
            $billImagePath = $this->uploadFile(
                $request->file('bill_image'),
                null,
                'bills/images'
            );
        }
        $itemsAddon = ItemsAddon::create([
            'item_id' => $request->input('item_id'),
            'description' => $request->input('description'),
            'price_usd' => $request->input('price_usd'),
            'price_afg' => $request->input('price_afg'),
            'quantity' => $request->input('quantity'),
            'bill_image' => $billImagePath,
            'date' => $request->input('date'),
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Items addon stored successfully',
            'status' => 201,
            'data' => $itemsAddon,
        ], 201);
    }

    public function show(ItemsAddon $itemsAddon)
    {
        $itemsAddon->load(['item']);
        return response()->json([
            'success' => true,
            'message' => 'Items addon retrieved successfully',
            'status' => 200,
            'data' => $itemsAddon,
        ], 200);
    }

    public function update(UpdateItemsAddonRequest $request, ItemsAddon $itemsAddon)
    {
        
        $billImagePath = $itemsAddon->bill_image;
              // Update 'bill_image' if it exists
        if ($request->hasFile('bill_image')) {
            $billImagePath = $this->uploadFile(
                $request->file('bill_image'),
                $itemsAddon->bill_image,
                'bills/images'
            );
        }
        $itemsAddon->update([
            'item_id' => $request->input('item_id'),
            'description' => $request->input('description'),
            'price_usd' => $request->input('price_usd'),
            'price_afg' => $request->input('price_afg'),
            'quantity' => $request->input('quantity'),
            'bill_image' => $billImagePath,
            'date' => $request->input('date'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Items addon updated successfully',
            'status' => 200,
            'data' => $itemsAddon,
        ], 200);
    }

    public function destroy(ItemsAddon $itemsAddon)
    {
        $itemsAddon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Items addon deleted successfully',
            'status' => 200,
        ], 200);
    }
}
