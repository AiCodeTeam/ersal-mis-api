<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define general permissions
        $permissions = [
            'view',
            'create',
            'update',
            'delete',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);

        // Assign Permissions to Roles
        $admin->givePermissionTo($permissions);
        $editor->givePermissionTo('view');

        // Assign Role to Users
        $adminUser = User::find(12); // Admin user
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }

        $editorUsers = User::where('id', '!=', 12)->get(); // All other users
        foreach ($editorUsers as $editorUser) {
            $editorUser->assignRole('editor');
        }
    }
}
