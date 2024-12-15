<?php

namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemsAddonRequest;
use App\Http\Requests\UpdateItemsAddonRequest;
use App\Models\ItemsAddon;
use Illuminate\Http\Request;

class ItemsAddonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ItemsAddon::paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);
    }

    public function store(StoreItemsAddonRequest $request)
    {
        $itemsAddon = ItemsAddon::create([
            'item_id' => $request->input('item_id'),
            'description' => $request->input('description'),
            'price_usd' => $request->input('price_usd'),
            'price_afg' => $request->input('price_afg'),
            'quantity' => $request->input('quantity'),
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
        return response()->json([
            'success' => true,
            'message' => 'Items addon retrieved successfully',
            'status' => 200,
            'data' => $itemsAddon,
        ], 200);
    }

    public function update(UpdateItemsAddonRequest $request, ItemsAddon $itemsAddon)
    {
        $itemsAddon->update([
            'item_id' => $request->input('item_id'),
            'description' => $request->input('description'),
            'price_usd' => $request->input('price_usd'),
            'price_afg' => $request->input('price_afg'),
            'quantity' => $request->input('quantity'),
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
