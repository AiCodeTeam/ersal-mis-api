<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define roles and their corresponding models and permission types
        $rolesPermissions = [
            'admin' => [
                'models' => ['User', 'Category', 'Customer', 'Expense', 'ExpenseCategory', 'Item', 'ItemsAddon', 'Order', 'Product', 'ProductImage', 'ProductItem'],
                'permissions' => ['view', 'create', 'update', 'delete'],
            ],
            'editor' => [
                'models' => ['Category', 'Customer', 'Expense', 'ExpenseCategory', 'Item', 'ItemsAddon', 'Order', 'Product', 'ProductImage', 'ProductItem'],
                'permissions' => ['view', 'create', 'update'],
            ],
            'viewer' => [
                'models' => ['Category', 'Customer', 'Expense', 'ExpenseCategory', 'Item', 'ItemsAddon', 'Order', 'Product', 'ProductImage', 'ProductItem'],
                'permissions' => ['view'],
            ],
        ];

        // Create roles and assign permissions
        foreach ($rolesPermissions as $roleName => $roleData) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($roleData['models'] as $model) {
                foreach ($roleData['permissions'] as $permissionType) {
                    $permissionName = "{$permissionType} {$model}";
                    $permission = Permission::firstOrCreate(['name' => $permissionName]);
                    $role->givePermissionTo($permission);
                }
            }
        }

        // Define default users for each role
        $users = [
            'admin' => [
                'email' => 'admin@ersalapp.com',
                'name' => 'Admin User',
                'password' => bcrypt('password@123'),
            ],
            'editor' => [
                'email' => 'editor@ersalapp.com',
                'name' => 'Editor User',
                'password' => bcrypt('editor@123'),
            ],
            'viewer' => [
                'email' => 'viewer@ersalapp.com',
                'name' => 'Viewer User',
                'password' => bcrypt('viewer@123'),
            ],
        ];

        // Create users and assign roles
        foreach ($users as $roleName => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => $userData['password']]
            );

            $user->assignRole($roleName);
        }
    }
}
