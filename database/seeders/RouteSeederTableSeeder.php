<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RouteSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Model::unguard();

        // // Dashboard
        // Route::insert([
        //     [
        //         'route' => 'dashboard.index',
        //         'permission_name' => 'dashboard_index',
        //     ],
        // ]);

        // // General Setting
        // Route::insert([
        //     [
        //         'route' => 'setting.index',
        //         'permission_name' => 'setting_index',
        //     ],
        //     [
        //         'route' => 'setting.update',
        //         'permission_name' => 'setting_update',
        //     ],
        // ]);

        // // User Management
        // Route::insert([
        //     [
        //         'route' => 'user.index',
        //         'permission_name' => 'user_index',
        //     ],
        //     [
        //         'route' => 'user.store',
        //         'permission_name' => 'user_store',
        //     ],
        //     [
        //         'route' => 'user.update',
        //         'permission_name' => 'user_update',
        //     ],
        //     [
        //         'route' => 'user.destroy',
        //         'permission_name' => 'user_destroy',
        //     ],
        // ]);

        // // User Profile
        // Route::insert([
        //     [
        //         'route' => 'profile.index',
        //         'permission_name' => 'profile_index',
        //     ],
        // ]);

        // // Menu Group Management
        // Route::insert([
        //     [
        //         'route' => 'menu.index',
        //         'permission_name' => 'menu_index',
        //     ],
        //     [
        //         'route' => 'menu.store',
        //         'permission_name' => 'menu_store',
        //     ],
        //     [
        //         'route' => 'menu.update',
        //         'permission_name' => 'menu_update',
        //     ],
        //     [
        //         'route' => 'menu.destroy',
        //         'permission_name' => 'menu_destroy',
        //     ],
        // ]);

        // // Menu Item Management
        // Route::insert([
        //     [
        //         'route' => 'menu.item.index',
        //         'permission_name' => 'menu_item_index',
        //     ],
        //     [
        //         'route' => 'menu.item.store',
        //         'permission_name' => 'menu_item_store',
        //     ],
        //     [
        //         'route' => 'menu.item.update',
        //         'permission_name' => 'menu_item_update',
        //     ],
        //     [
        //         'route' => 'menu.item.destroy',
        //         'permission_name' => 'menu_item_destroy',
        //     ],
        // ]);

        // // Route Management
        // Route::insert([
        //     [
        //         'route' => 'route.index',
        //         'permission_name' => 'route_index',
        //     ],
        //     [
        //         'route' => 'route.store',
        //         'permission_name' => 'route_store',
        //     ],
        //     [
        //         'route' => 'route.update',
        //         'permission_name' => 'route_update',
        //     ],
        //     [
        //         'route' => 'route.destroy',
        //         'permission_name' => 'route_destroy',
        //     ],
        // ]);

        // // Role Management
        // Route::insert([
        //     [
        //         'route' => 'role.index',
        //         'permission_name' => 'role_index',
        //     ],
        //     [
        //         'route' => 'role.store',
        //         'permission_name' => 'role_store',
        //     ],
        //     [
        //         'route' => 'role.update',
        //         'permission_name' => 'role_update',
        //     ],
        //     [
        //         'route' => 'role.destroy',
        //         'permission_name' => 'role_destroy',
        //     ],
        // ]);

        // // Permission Management
        // Route::insert([
        //     [
        //         'route' => 'permission.index',
        //         'permission_name' => 'permission_index',
        //     ],
        //     [
        //         'route' => 'permission.store',
        //         'permission_name' => 'permission_store',
        //     ],
        //     [
        //         'route' => 'permission.update',
        //         'permission_name' => 'permission_update',
        //     ],
        //     [
        //         'route' => 'permission.destroy',
        //         'permission_name' => 'permission_destroy',
        //     ],
        // ]);

        $routes = [

            ['route' => 'login', 'permission_name' => 'dashboard_index'],

            ['route' => 'setting.index', 'permission_name' => 'setting_index'],
            ['route' => 'setting.update', 'permission_name' => 'setting_update'],

            ['route' => 'user.index', 'permission_name' => 'user_index'],
            ['route' => 'user.store', 'permission_name' => 'user_store'],
            ['route' => 'user.update', 'permission_name' => 'user_update'],
            ['route' => 'user.destroy', 'permission_name' => 'user_destroy'],
            ['route' => 'profile.index', 'permission_name' => 'profile_index'],

            ['route' => 'menu.index', 'permission_name' => 'menu_index'],
            ['route' => 'menu.store', 'permission_name' => 'menu_store'],
            ['route' => 'menu.update', 'permission_name' => 'menu_update'],
            ['route' => 'menu.destroy', 'permission_name' => 'menu_destroy'],

            ['route' => 'menu.item.index', 'permission_name' => 'menu_item_index'],
            ['route' => 'menu.item.store', 'permission_name' => 'menu_item_store'],
            ['route' => 'menu.item.update', 'permission_name' => 'menu_item_update'],
            ['route' => 'menu.item.destroy', 'permission_name' => 'menu_item_destroy'],

            ['route' => 'route.index', 'permission_name' => 'route_index'],
            ['route' => 'route.store', 'permission_name' => 'route_store'],
            ['route' => 'route.update', 'permission_name' => 'route_update'],
            ['route' => 'route.destroy', 'permission_name' => 'route_destroy'],

            ['route' => 'role.index', 'permission_name' => 'role_index'],
            ['route' => 'role.store', 'permission_name' => 'role_store'],
            ['route' => 'role.update', 'permission_name' => 'role_update'],
            ['route' => 'role.destroy', 'permission_name' => 'role_destroy'],

            ['route' => 'permission.index', 'permission_name' => 'permission_index'],
            ['route' => 'permission.store', 'permission_name' => 'permission_store'],
            ['route' => 'permission.update', 'permission_name' => 'permission_update'],
            ['route' => 'permission.destroy', 'permission_name' => 'permission_destroy'],

            ['route' => 'backsite.archive-container.index', 'permission_name' => 'archive_container_index'],
            ['route' => 'backsite.archive-container.create', 'permission_name' => 'archive_container_create'],
            ['route' => 'backsite.archive-container.store', 'permission_name' => 'archive_container_store'],
            ['route' => 'backsite.archive-container.edit', 'permission_name' => 'archive_container_edit'],
            ['route' => 'backsite.archive-container.update', 'permission_name' => 'archive_container_update'],
            ['route' => 'backsite.archive-container.destroy', 'permission_name' => 'archive_container_destroy'],
            ['route' => 'backsite.archive-container.show', 'permission_name' => 'archive_container_show'],

            ['route' => 'backsite.company.create', 'permission_name' => 'company_create'],
            ['route' => 'backsite.company.destroy', 'permission_name' => 'company_destroy'],
            ['route' => 'backsite.company.edit', 'permission_name' => 'company_edit'],
            ['route' => 'backsite.company.index', 'permission_name' => 'company_index'],
            ['route' => 'backsite.company.show', 'permission_name' => 'company_show'],
            ['route' => 'backsite.company.store', 'permission_name' => 'company_store'],
            ['route' => 'backsite.company.update', 'permission_name' => 'company_update'],

            ['route' => 'backsite.main-location.index', 'permission_name' => 'main_location_index'],
            ['route' => 'backsite.main-location.create', 'permission_name' => 'main_location_create'],
            ['route' => 'backsite.main-location.edit', 'permission_name' => 'main_location_edit'],
            ['route' => 'backsite.main-location.destroy', 'permission_name' => 'main_location_destroy'],
            ['route' => 'backsite.main-location.store', 'permission_name' => 'main_location_store'],
            ['route' => 'backsite.main-location.update', 'permission_name' => 'main_location_update'],

            ['route' => 'backsite.sub-location.index', 'permission_name' => 'sub_location_index'],
            ['route' => 'backsite.sub-location.create', 'permission_name' => 'sub_location_create'],
            ['route' => 'backsite.sub-location.destroy', 'permission_name' => 'sub_location_destroy'],
            ['route' => 'backsite.sub-location.edit', 'permission_name' => 'sub_location_edit'],
            ['route' => 'backsite.sub-classification.store', 'permission_name' => 'sub_location_store'],
            ['route' => 'backsite.sub-location.update', 'permission_name' => 'sub_location_update'],

            ['route' => 'backsite.detail-location.create', 'permission_name' => 'detail_location_create'],
            ['route' => 'backsite.detail-location.destroy', 'permission_name' => 'detail_location_destroy'],
            ['route' => 'backsite.detail-location.edit', 'permission_name' => 'detail_location_edit'],
            ['route' => 'backsite.detail-location.index', 'permission_name' => 'detail_location_index'],
            ['route' => 'backsite.detail-location.store', 'permission_name' => 'detail_location_store'],
            ['route' => 'backsite.detail-location.update', 'permission_name' => 'detail_location_update'],

            ['route' => 'backsite.container-location.create', 'permission_name' => 'container_location_create'],
            ['route' => 'backsite.container-location.destroy', 'permission_name' => 'container_location_destroy'],
            ['route' => 'backsite.container-location.edit', 'permission_name' => 'container_location_edit'],
            ['route' => 'backsite.container-location.index', 'permission_name' => 'container_location_index'],
            ['route' => 'backsite.container-location.store', 'permission_name' => 'container_location_store'],
            ['route' => 'backsite.container-location.update', 'permission_name' => 'container_location_update'],

            ['route' => 'backsite.division.create', 'permission_name' => 'division_create'],
            ['route' => 'backsite.division.destroy', 'permission_name' => 'division_destroy'],
            ['route' => 'backsite.division.edit', 'permission_name' => 'division_edit'],
            ['route' => 'backsite.division.index', 'permission_name' => 'division_index'],
            ['route' => 'backsite.division.store', 'permission_name' => 'division_store'],
            ['route' => 'backsite.division.update', 'permission_name' => 'division_update'],
            // ['route' => 'backsite.department.create', 'permission_name' => 'department_create'],
            // ['route' => 'backsite.department.destroy', 'permission_name' => 'department_destroy'],
            // ['route' => 'backsite.department.edit', 'permission_name' => 'department_edit'],
            // ['route' => 'backsite.department.index', 'permission_name' => 'department_index'],
            // ['route' => 'backsite.department.store', 'permission_name' => 'department_store'],
            // ['route' => 'backsite.department.update', 'permission_name' => 'department_update'],
            // ['route' => 'backsite.section.create', 'permission_name' => 'section_create'],
            // ['route' => 'backsite.section.destroy', 'permission_name' => 'section_destroy'],
            // ['route' => 'backsite.section.edit', 'permission_name' => 'section_edit'],
            // ['route' => 'backsite.section.index', 'permission_name' => 'section_index'],
            // ['route' => 'backsite.section.store', 'permission_name' => 'section_store'],
            // ['route' => 'backsite.section.update', 'permission_name' => 'section_update'],
            ['route' => 'backsite.main-classification.create', 'permission_name' => 'main_classification_create'],
            ['route' => 'backsite.main-classification.destroy', 'permission_name' => 'main_classification_destroy'],
            ['route' => 'backsite.main-classification.edit', 'permission_name' => 'main_classification_edit'],
            ['route' => 'backsite.main-classification.index', 'permission_name' => 'main_classification_index'],
            ['route' => 'backsite.main-classification.store', 'permission_name' => 'main_classification_store'],
            ['route' => 'backsite.main-classification.update', 'permission_name' => 'main_classification_update'],

            ['route' => 'backsite.sub-classification.create', 'permission_name' => 'sub_classification_create'],
            ['route' => 'backsite.sub-classification.destroy', 'permission_name' => 'sub_classification_destroy'],
            ['route' => 'backsite.sub-classification.edit', 'permission_name' => 'sub_classification_edit'],
            ['route' => 'backsite.sub-classification.index', 'permission_name' => 'sub_classification_index'],
            ['route' => 'backsite.sub-classification.store', 'permission_name' => 'sub_classification_store'],
            ['route' => 'backsite.sub-classification.update', 'permission_name' => 'sub_classification_update'],
            // ['route' => 'backsite.retention.create', 'permission_name' => 'retention_create'],
            // ['route' => 'backsite.retention.destroy', 'permission_name' => 'retention_destroy'],
            // ['route' => 'backsite.retention.edit', 'permission_name' => 'retention_edit'],
            // ['route' => 'backsite.retention.index', 'permission_name' => 'retention_index'],
            // ['route' => 'backsite.retention.store', 'permission_name' => 'retention_store'],
            // ['route' => 'backsite.retention.update', 'permission_name' => 'retention_update'],
            ['route' => 'backsite.lending-archive.index', 'permission_name' => 'lending_archive_index'],
            ['route' => 'backsite.destruction-archive.index', 'permission_name' => 'destruction_archive'],
            ['route' => 'backsite.folder.index', 'permission_name' => 'folder_division'],
            // ['route' => 'login', 'permission_name' => 'activity_log'],
            ['route' => 'activity-log.index', 'permission_name' => 'activity-log'],
            ['route' => 'backsite.dataArchive', 'permission_name' => 'all_archive'],
        ];
        Route::insert($routes);
    }
}
