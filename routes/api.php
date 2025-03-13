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
    $user = $request->user();
    $user->all_permissions = $user->getAllPermissionsAttribute();
    return $user;
});

Route::prefix('v1')->group(function () {

    // Customers routes
    Route::apiResource('customers', CustomerController::class)
    ->middleware([
        'index' => 'permission:view Customer',
        'store' => 'permission:create Customer',
        'update' => 'permission:update Customer',
        'destroy' => 'permission:delete Customer',
        'show' => 'permission:view Customer',
    ]);

    // Orders routes
    Route::apiResource('orders', OrderController::class)
    ->middleware([
        'index' => 'permission:view Order',
        'store' => 'permission:create Order',
        'update' => 'permission:update Order',
        'destroy' => 'permission:delete Order',
        'show' => 'permission:view Order',
    ]);

    // Products routes
    Route::apiResource('products', ProductController::class)
    ->middleware([
        'index' => 'permission:view Product',
        'store' => 'permission:create Product',
        'update' => 'permission:update Product',
        'destroy' => 'permission:delete Product',
        'show' => 'permission:view Product',
    ]);

    // Categories routes
    Route::apiResource('category', ProductCategoryController::class)
    ->middleware([
        'index' => 'permission:view Category',
        'store' => 'permission:create Category',
        'update' => 'permission:update Category',
        'destroy' => 'permission:delete Category',
        'show' => 'permission:view Category',
    ]);
    // Product Images routes
    Route::apiResource('products-images', ProductImageController::class)
    ->middleware([
        'index' => 'permission:view ProductImage',
        'store' => 'permission:create ProductImage',
        'update' => 'permission:update ProductImage',
        'destroy' => 'permission:delete ProductImage',
        'show' => 'permission:view ProductImage',
    ]);

    // Items routes
    Route::apiResource('items', ItemController::class)
    ->middleware([
        'index' => 'permission:view Item',
        'store' => 'permission:create Item',
        'update' => 'permission:update Item',
        'destroy' => 'permission:delete Item',
        'show' => 'permission:view Item',
    ]);

    // Product Items routes
    Route::apiResource('product-items', ProductItemController::class)
    ->middleware([
        'index' => 'permission:view ProductItem',
        'store' => 'permission:create ProductItem',
        'update' => 'permission:update ProductItem',
        'destroy' => 'permission:delete ProductItem',
        'show' => 'permission:view ProductItem',
    ]);

    // Items Addons routes;
    Route::apiResource('items-addons', ItemsAddonController::class)
    ->middleware([
        'index' => 'permission:view ItemsAddon',
        'store' => 'permission:create ItemsAddon',
        'update' => 'permission:update ItemsAddon',
        'destroy' => 'permission:delete ItemsAddon',
        'show' => 'permission:view ItemsAddon',
    ]);

    // Expenses routes;
    Route::apiResource('expenses', ExpenseController::class)
    ->middleware([
        'index' => 'permission:view Expense',
        'store' => 'permission:create Expense',
        'update' => 'permission:update Expense',
        'destroy' => 'permission:delete Expense',
        'show' => 'permission:view Expense',
    ]);

    // Expense Categories routes
    Route::apiResource('expense-categories', ExpenseCategoryController::class)
    ->middleware([
        'index' => 'permission:view ExpenseCategory',
        'store' => 'permission:create ExpenseCategory',
        'update' => 'permission:update ExpenseCategory',
        'destroy' => 'permission:delete ExpenseCategory',
        'show' => 'permission:view ExpenseCategory',
    ]);

    // User-specific routes with admin-only access
        Route::get('/users/roles-permissions', [UserController::class, 'rolesAndPermission'])
        ->middleware([
            'index' => 'permission:view Role',
            'store' => 'permission:create Role',
            'update' => 'permission:update Role',
            'destroy' => 'permission:delete Role',
            'show' => 'permission:view Role',
        ]);
        
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')
        ->middleware([
            'index' => 'permission:view User',
            'store' => 'permission:create User',
            'update' => 'permission:update User',
            'destroy' => 'permission:delete User',
            'show' => 'permission:view User',
        ]);
        Route::get('/users', [UserController::class, 'index'])->name('users.index')
        ->middleware([
            'index' => 'permission:view User',
            'store' => 'permission:create User',
            'update' => 'permission:update User',
            'destroy' => 'permission:delete User',
            'show' => 'permission:view User',
        ]);
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')
        ->middleware([
            'index' => 'permission:view User',
            'store' => 'permission:create User',
            'update' => 'permission:update User',
            'destroy' => 'permission:delete User',
            'show' => 'permission:view User',
        ]);
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')
        ->middleware([
            'index' => 'permission:view User',
            'store' => 'permission:create User',
            'update' => 'permission:update User',
            'destroy' => 'permission:delete User',
            'show' => 'permission:view User',
        ]);
   

    // Expense category dropdown (view permission required)
    Route::get('/expense-category-dropdown', [ExpenseController::class, 'expenseCategoryDropdown'])
        ->middleware('permission:view ExpenseCategory');

    // Role and permission management (admin-only)

        Route::post('/create-role', [RolePermissionController::class, 'createRole'])
        ->middleware([
            'index' => 'permission:view Role',
            'store' => 'permission:create Role',
            'update' => 'permission:update Role',
            'destroy' => 'permission:delete Role',
            'show' => 'permission:view Role',
        ]);

        Route::put('/update-role/{role}', [RolePermissionController::class, 'updateRole'])
        ->middleware([
            // 'index' => 'permission:view Role',
            // 'store' => 'permission:create Role',
            // 'update' => 'permission:update Role',
            // 'destroy' => 'permission:delete Role',
            // 'show' => 'permission:view Role',
        ]);
        Route::delete('/delete-role/{role}', [RolePermissionController::class, 'deleteRole'])
        ->middleware([
            // 'index' => 'permission:view Role',
            // 'store' => 'permission:create Role',
            // 'update' => 'permission:update Role',
            // 'destroy' => 'permission:delete Role',
            // 'show' => 'permission:view Role',
        ]);
        Route::post('/assign-permissions-to-role', [RolePermissionController::class, 'assignPermissionsToRole'])
        ->middleware([
            // 'index' => 'permission:view Role',
            // 'store' => 'permission:create Role',
            // 'update' => 'permission:update Role',
            // 'destroy' => 'permission:delete Role',
            // 'show' => 'permission:view Role',
        ]);
        Route::post('/assign-role-to-user', [RolePermissionController::class, 'assignRoleToUser'])
        ->middleware([
            'index' => 'permission:view Role',
            'store' => 'permission:create Role',
            'update' => 'permission:update Role',
            'destroy' => 'permission:delete Role',
            'show' => 'permission:view Role',
        ]);
        Route::post('/revoke-role-from-user', [RolePermissionController::class, 'revokeRoleFromUser'])
        ->middleware([
            'index' => 'permission:view Role',
            'store' => 'permission:create Role',
            'update' => 'permission:update Role',
            'destroy' => 'permission:delete Role',
            'show' => 'permission:view Role',
        ]);
        Route::post('/revoke-permissions-from-role', [RolePermissionController::class, 'revokePermissionsFromRole'])
        ->middleware([
            'index' => 'permission:view Permission',
            'store' => 'permission:create Permission',
            'update' => 'permission:update Permission',
            'destroy' => 'permission:delete Permission',
            'show' => 'permission:view Permission',
        ]);
        Route::post('/revome-all-roles-from-user', [RolePermissionController::class, 'revokeAllRolesFromUser'])
        ->middleware([
            'index' => 'permission:view Role',
            'store' => 'permission:create Role',
            'update' => 'permission:update Role',
            'destroy' => 'permission:delete Role',
            'show' => 'permission:view Role',
        ]);
        Route::post('/detach-all-permissions-from-role', [RolePermissionController::class, 'revokeAllPermissionsFromRole'])
        ->middleware([
            'index' => 'permission:view Permission',
            'store' => 'permission:create Permission',
            'update' => 'permission:update Permission',
            'destroy' => 'permission:delete Permission',
            'show' => 'permission:view Permission',
        ]);
        Route::get('/list-roles', [RolePermissionController::class, 'listRoles'])
        ->middleware([
            'index' => 'permission:view Role',
            'store' => 'permission:create Role',
            'update' => 'permission:update Role',
            'destroy' => 'permission:delete Role',
            'show' => 'permission:view Role',
        ]);
        Route::get('/list-roles/{id}', [RolePermissionController::class, 'showRole'])
        ->middleware([
            'index' => 'permission:view Role',
            'store' => 'permission:create Role',
            'update' => 'permission:update Role',
            'destroy' => 'permission:delete Role',
            'show' => 'permission:view Role',
        ]);
        Route::get('/list-permissions', [RolePermissionController::class, 'listPermissions'])
        ->middleware([
            'index' => 'permission:view Permission',
            'store' => 'permission:create Permission',
            'update' => 'permission:update Permission',
            'destroy' => 'permission:delete Permission',
            'show' => 'permission:view Permission',
        ]);
});