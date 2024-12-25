<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->limit) return Expense::all();
        return Expense::with('expenseCategory')->paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);

    }
    public function expenseCategoryDropdown() {
        $dropdown = ExpenseCategory::select('id','name')->get();
        return response()->json([
            'success' => true,
            'message' => 'Expense Category fetched successfully',
            'status' => 200,
            'data' => $dropdown,
        ], 200);
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create([
            'details' => $request->input('details'),
            'price' => $request->input('price'),
            'date' => $request->input('date'),
            'expense_categories_id' => $request->input('expense_categories_id'),
            'user_id' => Auth::id(),
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
    
        $expense->load('expenseCategory');

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
            'user_id' => Auth::id(),
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
