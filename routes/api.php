<?php

use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\v1\ItemsAddonController;
use App\Http\Controllers\v1\CustomerController;
use App\Http\Controllers\v1\ExpenseCategoryController;
use App\Http\Controllers\v1\ExpenseController;
use App\Http\Controllers\v1\ItemController;
use App\Http\Controllers\v1\OrderController;
use App\Http\Controllers\v1\ProductCategoryController;
use App\Http\Controllers\v1\ProductController;
use App\Http\Controllers\v1\ProductImageController;
use App\Http\Controllers\v1\ProductItemController;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');

Route::prefix('v1')->group(function () {

    // Customers routes
    Route::apiResource('customers', CustomerController::class)
        ->middleware('permission:view Customer|create Customer|update Customer|delete Customer');

    // Orders routes
    Route::apiResource('orders', OrderController::class)
        ->middleware('permission:view Order|create Order|update Order|delete Order');

    // Products routes
    Route::apiResource('products', ProductController::class)
        ->middleware('permission:view Product|create Product|update Product|delete Product');

    // Categories routes
    Route::apiResource('category', ProductCategoryController::class)
        ->middleware('permission:view Category|create Category|update Category|delete Category');

    // Product Images routes
    Route::apiResource('products-images', ProductImageController::class)
        ->middleware('permission:view ProductImage|create ProductImage|update ProductImage|delete ProductImage');

    // Items routes
    Route::apiResource('items', ItemController::class)
        ->middleware('permission:view Item|create Item|update Item|delete Item');

    // Product Items routes
    Route::apiResource('product-items', ProductItemController::class)
        ->middleware('permission:view ProductItem|create ProductItem|update ProductItem|delete ProductItem');

    // Items Addons routes
    Route::apiResource('items-addons', ItemsAddonController::class)
        ->middleware('permission:view ItemsAddon|create ItemsAddon|update ItemsAddon|delete ItemsAddon');

    // Expenses routes
    Route::apiResource('expenses', ExpenseController::class)
        ->middleware('permission:view Expense|create Expense|update Expense|delete Expense');

    // Expense Categories routes
    Route::apiResource('expense-categories', ExpenseCategoryController::class)
        ->middleware('permission:view ExpenseCategory|create ExpenseCategory|update ExpenseCategory|delete ExpenseCategory');

    // User-specific routes with admin-only access
    Route::middleware('role:admin')->group(function () {
        Route::get('/users/roles-permissions', [UserController::class, 'rolesAndPermission']);
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Expense category dropdown (view permission required)
    Route::get('/expense-category-dropdown', [ExpenseController::class, 'expenseCategoryDropdown'])
        ->middleware('permission:view ExpenseCategory');

    // Role and permission management (admin-only)
    // Route::middleware('role:admin')->group(function () {
    //     Route::post('/create-role', [RolePermissionController::class, 'createRole']);
    //     Route::post('/create-permission', [RolePermissionController::class, 'createPermission']);
    //     Route::post('/assign-permissions-to-role', [RolePermissionController::class, 'assignPermissionsToRole']);
    //     Route::post('/assign-role-to-user', [RolePermissionController::class, 'assignRoleToUser']);
    //     Route::post('/revoke-role-from-user', [RolePermissionController::class, 'revokeRoleFromUser']);
    //     Route::post('/revoke-permissions-from-role', [RolePermissionController::class, 'revokePermissionsFromRole']);
    //     Route::post('/revome-all-roles-from-user', [RolePermissionController::class, 'revokeAllRolesFromUser']);
    //     Route::post('/detach-all-permissions-from-role', [RolePermissionController::class, 'revokeAllPermissionsFromRole']);
    //     Route::get('/list-roles', [RolePermissionController::class, 'listRoles']);
    //     Route::get('/list-roles/{id}', [RolePermissionController::class, 'showRole']);
    //     Route::get('/list-permissions', [RolePermissionController::class, 'listPermissions']);
    // });
    Route::post('/create-role', [RolePermissionController::class, 'createRole']);
    Route::post('/create-permission', [RolePermissionController::class, 'createPermission']);
    Route::post('/assign-permissions-to-role', [RolePermissionController::class, 'assignPermissionsToRole']);
    Route::post('/assign-role-to-user', [RolePermissionController::class, 'assignRoleToUser']);
    Route::post('/revoke-role-from-user', [RolePermissionController::class, 'revokeRoleFromUser']);
    Route::post('/revoke-permissions-from-role', [RolePermissionController::class, 'revokePermissionsFromRole']);
    Route::post('/revome-all-roles-from-user', [RolePermissionController::class, 'revokeAllRolesFromUser']);
    Route::post('/detach-all-permissions-from-role', [RolePermissionController::class, 'revokeAllPermissionsFromRole']);
    Route::get('/list-roles', [RolePermissionController::class, 'listRoles']);
    Route::get('/list-roles/{id}', [RolePermissionController::class, 'showRole']);
    Route::get('/list-permissions', [RolePermissionController::class, 'listPermissions']);
    Route::put('/roles/{id}', [RolePermissionController::class, 'updateRole']);
    Route::delete('/roles/{id}', [RolePermissionController::class, 'deleteRole']);
});