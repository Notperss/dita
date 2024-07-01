<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Model::unguard();

        $permissionAdmin = [
            'admin',
            'all_archive',
            'approval',
            'archive_container_create',
            'archive_container_destroy',
            'archive_container_edit',
            'archive_container_index',
            'archive_container_show',
            'archive_container_store',
            'archive_container_update',
            'classification',
            'container_location_create',
            'container_location_destroy',
            'container_location_edit',
            'container_location_index',
            'container_location_store',
            'container_location_update',
            'create_folder',
            'dashboard_index',
            'destruction_archive',
            'detail_location_create',
            'detail_location_destroy',
            'detail_location_edit',
            'detail_location_index',
            'detail_location_store',
            'detail_location_update',
            'division_create',
            'division_destroy',
            'division_edit',
            'division_index',
            'division_store',
            'division_update',
            'folder_division',
            'general',
            'lending archive',
            'lending_archive_index',
            'location',
            'main_classification_create',
            'main_classification_destroy',
            'main_classification_edit',
            'main_classification_index',
            'main_classification_store',
            'main_classification_update',
            'main_location_create',
            'main_location_destroy',
            'main_location_edit',
            'main_location_index',
            'main_location_store',
            'main_location_update',
            'master data',
            'sub_classification_create',
            'sub_classification_destroy',
            'sub_classification_edit',
            'sub_classification_index',
            'sub_classification_store',
            'sub_classification_update',
            'sub_location_create',
            'sub_location_destroy',
            'sub_location_edit',
            'sub_location_index',
            'sub_location_store',
            'sub_location_update',
            'transaksi arsip',
            'view_archive',];

        // $this->call("OthersTableSeeder");

        $superadmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);
        $adminDivision = Role::create(['name' => 'Admin-divisi']);
        $userDivision = Role::create(['name' => 'User-divisi']);

        $superadmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo([$permissionAdmin]);
        $user->givePermissionTo([
            'approval',
            'archive_container_create',
            'archive_container_index',
            'container_location_create',
            'container_location_index',
            'dashboard_index',
            'folder_division',
            'general',
            'location',
            'master data',
            'profile_index',
            'transaksi arsip',
            'user',
        ]);
        $adminDivision->givePermissionTo([
            'create_folder',
            'destruction_archive',
            'folder_division',
            'lending archive',
            'lending_archive_index',
            'transaksi arsip',
            'user',
        ]);
        $userDivision->givePermissionTo([
            'destruction_archive',
            'folder_division',
            'lending archive',
            'lending_archive_index',
            'transaksi arsip',
        ]);

        User::firstWhere('email', 'superadmin@mail.com')->assignRole('Super Admin');
        User::firstWhere('email', 'admin@mail.com')->assignRole('Admin');
        User::firstWhere('email', 'user@mail.com')->assignRole('User');
        User::firstWhere('email', 'admin-divisi@mail.com')->assignRole('Admin-divisi');
        User::firstWhere('email', 'user-divisi@mail.com')->assignRole('User-divisi');
    }
}







