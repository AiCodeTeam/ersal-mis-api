<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    public function index()
    {
        return response()->json(Category::all(), 200);
    }


    public function store(StoreProductCategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product category created successfully',
            'status' => 201,
            'data' => $category,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, Category $category)
    {
      
        $category->update([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product category updated successfully',
            'status' => 200,
            'data' => $category,
        ], 200);
    }


    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if the product category exists
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Product category not found',
                'status' => 404,
            ], 404);
        }

        // Proceed to delete if it exists
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product category deleted successfully',
            'status' => 200,
        ], 200);
    }
}
