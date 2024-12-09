<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();

        return response()->json([
            'success' => true,
            'message' => 'Expenses retrieved successfully',
            'status' => 200,
            'data' => $expenses,
        ], 200);
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create([
            'details' => $request->input('details'),
            'price' => $request->input('price'),
            'date' => $request->input('date'),
            'expense_categories_id' => $request->input('expense_categories_id'),
            'user_id' => $request->input('user_id'),
            'purchased_by' => $request->input('purchased_by'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Expense stored successfully',
            'status' => 201,
            'data' => $expense,
        ], 201);
    }

    public function show(Expense $expense = null)
    {
        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found!',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Expense retrieved successfully',
            'status' => 200,
            'data' => $expense,
        ], 200);
    }


    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update([
            'details' => $request->input('details'),
            'price' => $request->input('price'),
            'date' => $request->input('date'),
            'expense_categories_id' => $request->input('expense_categories_id'),
            'user_id' => $request->input('user_id'),
            'purchased_by' => $request->input('purchased_by'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Expense updated successfully',
            'status' => 200,
            'data' => $expense,
        ], 200);
    }

    public function destroy($id)
    {
        // Find the expense by ID
        $expense = Expense::find($id);

        // Check if the expense exists
        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found!',
                'status' => 404,
            ], 404);
        }

        // Perform soft delete on the expense
        $expense->delete();

        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully',
            'status' => 200,
        ], 200);
    }
}
