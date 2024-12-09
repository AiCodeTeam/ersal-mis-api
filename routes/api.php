<?php

use App\Http\Controllers\v1\ItemsAddonController;
use App\Http\Controllers\v1\CustomerController;
use App\Http\Controllers\v1\ExpenseCategoryController;
use App\Http\Controllers\v1\ExpenseController;
use App\Http\Controllers\v1\ItemController;
use App\Http\Controllers\v1\ProductCategoryController;
use App\Http\Controllers\v1\ProductController;
use App\Http\Controllers\v1\ProductImageController;
use App\Http\Controllers\v1\ProductItemController;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');

Route::prefix('v1')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('orders', App\Http\Controllers\v1\OrderController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('category', ProductCategoryController::class);
    Route::apiResource('products-images', ProductImageController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('product-items', ProductItemController::class);
    Route::apiResource('items-addons', ItemsAddonController::class);
    Route::apiResource('expenses', ExpenseController::class);
    Route::apiResource('expense-categories', ExpenseCategoryController::class);
});
