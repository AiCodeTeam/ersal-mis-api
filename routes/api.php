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



    Route::apiResource('customers', CustomerController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);

    // Orders routes with permissions
    Route::apiResource('orders', OrderController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);

    // Products routes with permissions
    Route::apiResource('products', ProductController::class);
    // Categories routes with permissions
    Route::apiResource('category', ProductCategoryController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);

    // Product Images routes with permissions
    Route::apiResource('products-images', ProductImageController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);

    // Items routes with permissions
    Route::apiResource('items', ItemController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);

    // Product Items routes with permissions
    Route::apiResource('product-items', ProductItemController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);

    // Items Addons routes with permissions
    Route::apiResource('items-addons', ItemsAddonController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);

    // Expenses routes with permissions
    Route::apiResource('expenses', ExpenseController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);

    // Expense Categories routes with permissions
    Route::apiResource('expense-categories', ExpenseCategoryController::class)->middleware([
        // 'index' => 'permission:view',
        // 'show' => 'permission:view',
        // 'store' => 'permission:create',
        // 'update' => 'permission:update',
        // 'destroy' => 'permission:delete',
    ]);
    Route::get('/users/roles-permissions', [UserController::class, 'rolesAndPermission']);
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    //expense category dropdonw
    Route::get('/expense-category-dropdown', [ExpenseController::class, 'expenseCategoryDropdown']);
    //role and permission route
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
});
