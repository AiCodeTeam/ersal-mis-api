<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index(Request $request)
    {
        return ExpenseCategory::paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);
    }

    public function store(StoreExpenseCategoryRequest $request)
    {
        $category = ExpenseCategory::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Expense category stored successfully',
            'status' => 201,
            'data' => $category,
        ], 201);
    }

    public function show(ExpenseCategory $expenseCategory)
    {
        if(!$expenseCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Expense Not found!',
                'status' => 404,
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Expense category retrieved successfully',
            'status' => 200,
            'data' => $expenseCategory,
        ], 200);
    }

    public function update(UpdateExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Expense category updated successfully',
            'status' => 200,
            'data' => $expenseCategory,
        ], 200);
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Expense category deleted successfully',
            'status' => 200,
        ], 200);
    }
}
