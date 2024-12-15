<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostOrderRequest $request)
    {
    
        $order = Order::create([
            'customer_id' => $request->input('customer_id'),
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'date' => $request->input('date'),
            'price_usa' => $request->input('price_usa'),
            'price_afn' => $request->input('price_afn'),
            'item_id' => $request->input('item_id'),
        ]);

        return response()->json([
            'success' => true,
            'message' => "order placed successfully",
            'status' => 201,
            'data' => $order
        ]);
    }


    public function show(Order $order)
    {
        // Return the order in a structured response
        return response()->json([
            'success' => true,
            'message' => 'Order found successfully.',
            'status' => 200,
            'data' => $order
        ], 200);
    }
    public function update(UpdateOrderRequest $request, Order $order)
    {
        // Update the order with the validated request data
        $order->update([
            'customer_id' => $request->input('customer_id'),
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'date' => $request->input('date'),
            'price_usa' => $request->input('price_usa'),
            'price_afn' => $request->input('price_afn'),
            'item_id' => $request->input('item_id'),
        ]);

        // Return a structured response
        return response()->json([
            'success' => true,
            'message' => 'Order has been updated successfully.',
            'status' => 200,
            'data' => $order
        ], 200);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Delete the order
        $order->delete();

        // Return a structured response
        return response()->json([
            'success' => true,
            'message' => 'Order has been deleted successfully.',
            'status' => 200,
        ], 200);
    }
}
