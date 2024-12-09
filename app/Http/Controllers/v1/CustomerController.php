<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withTrashed()->get();
         return response()->json($customers);
    }

    public function show($id)
    {
        // Load the customer with its related data (if applicable)
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found!',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Customer details retrieved successfully',
            'status' => 200,
            'data' => $customer,
        ], 200);
    }
    
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->all());
    
        return response()->json([
            'success' => true,
            'message' => 'Customer is stored successfully',
            'status' => 201,
            'data' => $customer,
        ], 201);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
       
        $customer->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Customer is updated successfully',
            'status' => 200,
            'data' => $customer,
        ], 200);
    }

    public function destroy(Customer $customer = null)
    {
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found!',
                'status' => 404,
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully',
            'status' => 200,
            'data' => $customer,
        ], 200);
    }
}
