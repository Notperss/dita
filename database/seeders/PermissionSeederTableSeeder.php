<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permission::create(['name' => 'general']);
        // Permission::create(['name' => 'setting']);

        // // dashboard
        // Permission::create(['name' => 'dashboard_index']);

        // // General Setting
        // Permission::create(['name' => 'setting_index']);
        // Permission::create(['name' => 'setting_update']);

        // // User Management
        // Permission::create(['name' => 'user_index']);
        // Permission::create(['name' => 'user_store']);
        // Permission::create(['name' => 'user_update']);
        // Permission::create(['name' => 'user_destroy']);

        // // User Profile
        // Permission::create(['name' => 'profile_index']);

        // // Menu Management Group
        // Permission::create(['name' => 'menu_index']);
        // Permission::create(['name' => 'menu_store']);
        // Permission::create(['name' => 'menu_update']);
        // Permission::create(['name' => 'menu_destroy']);

        // // Menu Management Items
        // Permission::create(['name' => 'menu_item_index']);
        // Permission::create(['name' => 'menu_item_store']);
        // Permission::create(['name' => 'menu_item_update']);
        // Permission::create(['name' => 'menu_item_destroy']);

        // // Route Management
        // Permission::create(['name' => 'route_index']);
        // Permission::create(['name' => 'route_store']);
        // Permission::create(['name' => 'route_update']);
        // Permission::create(['name' => 'route_destroy']);

        // // Role Management
        // Permission::create(['name' => 'role_index']);
        // Permission::create(['name' => 'role_store']);
        // Permission::create(['name' => 'role_update']);
        // Permission::create(['name' => 'role_destroy']);

        // // Permission Management
        // Permission::create(['name' => 'permission_index']);
        // Permission::create(['name' => 'permission_store']);
        // Permission::create(['name' => 'permission_update']);
        // Permission::create(['name' => 'permission_destroy']);

        $permissions = [
            'general',
            'setting',

            // Dashboard
            'dashboard_index',

            // General Settings
            'setting_index',
            'setting_update',

            // User Management
            'user_index',
            'user_store',
            'user_update',
            'user_destroy',
            'profile_index',

            // Menu Management
            'menu_index',
            'menu_store',
            'menu_update',
            'menu_destroy',
            'menu_item_index',
            'menu_item_store',
            'menu_item_update',
            'menu_item_destroy',

            // Route Management
            'route_index',
            'route_store',
            'route_update',
            'route_destroy',

            // Role Management
            'role_index',
            'role_store',
            'role_update',
            'role_destroy',

            // Permission Management
            'permission_index',
            'permission_store',
            'permission_update',
            'permission_destroy',

            // Master Data
            'master data',

            // Archive Transactions
            'transaksi arsip',

            // Archive Container Management
            'archive_container_index',
            'archive_container_create',
            'archive_container_store',
            'archive_container_edit',
            'archive_container_update',
            'archive_container_destroy',
            'archive_container_show',

            // Company Management
            'company_index',
            'company_create',
            'company_store',
            'company_edit',
            'company_update',
            'company_destroy',
            'company_show',

            // Location Management
            //MAIN
            'main_location_index',
            'main_location_create',
            'main_location_store',
            'main_location_edit',
            'main_location_update',
            'main_location_destroy',
            //SUB
            'sub_location_index',
            'sub_location_create',
            'sub_location_store',
            'sub_location_edit',
            'sub_location_update',
            'sub_location_destroy',
            //DETAIL
            'detail_location_index',
            'detail_location_create',
            'detail_location_store',
            'detail_location_edit',
            'detail_location_update',
            'detail_location_destroy',
            //CONTAINER
            'container_location_index',
            'container_location_create',
            'container_location_store',
            'container_location_edit',
            'container_location_update',
            'container_location_destroy',

            // Work Unit Management
            'division_index',
            'division_create',
            'division_store',
            'division_edit',
            'division_update',
            'division_destroy',

            // Classification Management
            //MAIN
            'main_classification_index',
            'main_classification_create',
            'main_classification_store',
            'main_classification_edit',
            'main_classification_update',
            'main_classification_destroy',
            //SUB
            'sub_classification_index',
            'sub_classification_create',
            'sub_classification_store',
            'sub_classification_edit',
            'sub_classification_update',
            'sub_classification_destroy',

            // Retention Management
            'retention_index',
            'retention_create',
            'retention_store',
            'retention_edit',
            'retention_update',
            'retention_destroy',

            // Archive Lending
            'lending_archive_index',
            'lending archive',

            // Archive Viewing
            'view_archive',

            // Approval Management
            'approval',

            // Special Permissions
            'super_admin',
            'destruction_archive',
            'admin',
            'user',

            // Folder Management
            'folder_division',
            'create_folder',

            // Activity Log
            'activity_log',

            // All Archives
            'all_archive',
            'classification',
            'location',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
