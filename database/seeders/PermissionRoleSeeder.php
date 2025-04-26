<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = [
            'Super Admin' => '*', // All permissions

            'Admin' => [
                'view_users',
                'create_users',
                'edit_users',
                'view_roles',
                'manage_roles',
                'view_vendors',
                'create_vendors',
                'edit_vendors',
                'view_products',
                'create_products',
                'edit_products',
                'delete_products',
                'view_categories',
                'manage_categories',
                'view_orders',
                'manage_orders',
                'cancel_orders',
                'view_customer_data',
                'manage_refunds',
            ],

            'Vendor Manager' => [
                'view_vendors',
                'create_vendors',
                'edit_vendors',
                'view_products',
                'edit_products',
                'view_orders',
                'manage_orders',
            ],

            'Vendor' => [
                'view_products',
                'create_products',
                'edit_products',
                'delete_products',
                'view_orders',
                'manage_orders',
            ],

            'Customer Service' => [
                'view_customer_data',
                'view_orders',
                'manage_support_tickets',
                'manage_refunds',
            ],

            'User' => [
                'view_products',
            ],

            'Guest' => [
                'view_products',
            ],
        ];

        $rolePermissionsToInsert = [];
        $roles = Role::all()->keyBy('name');
        $permissions = Permission::all();

        foreach ($rolePermissions as $roleName => $rolePerms) {
            $roleId = $roles[$roleName]->id;

            // If role should have all permissions
            if ($rolePerms === '*') {
                foreach ($permissions as $permission) {
                    $rolePermissionsToInsert[] = [
                        'permission_id' => $permission->id,
                        'role_id'       => $roleId,
                    ];
                }

                continue;
            }

            // Specific permissions for role
            foreach ($rolePerms as $permName) {
                $permission = $permissions->firstWhere('name', $permName);
                if ($permission) {
                    $rolePermissionsToInsert[] = [
                        'permission_id' => $permission->id,
                        'role_id'       => $roleId,
                    ];
                }
            }
        }

        DB::table('permission_role')->insert($rolePermissionsToInsert);
    }
}
