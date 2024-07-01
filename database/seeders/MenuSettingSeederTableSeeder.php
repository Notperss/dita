<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuGroup;
use App\Models\MenuItem;

class MenuSettingSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $menuGroups = [
            [
                'name' => 'Setting',
                'permission_name' => 'setting',
                'position' => 5,
                'items' => [
                    [
                        'name' => 'General Setting',
                        'icon' => 'ri-settings-2-line',
                        'route' => 'setting.index',
                        'permission_name' => 'setting_index',
                        'position' => 1,
                    ],
                    [
                        'name' => 'User Management',
                        'icon' => 'ri-file-user-line',
                        'route' => 'user.index',
                        'permission_name' => 'user_index',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Menu Management',
                        'icon' => 'ri-menu-line',
                        'route' => 'menu.index',
                        'permission_name' => 'menu_index',
                        'position' => 3,
                    ],
                    [
                        'name' => 'Route Management',
                        'icon' => 'ri-link',
                        'route' => 'route.index',
                        'permission_name' => 'route_index',
                        'position' => 4,
                    ],
                    [
                        'name' => 'Role Management',
                        'icon' => 'ri-shield-user-line',
                        'route' => 'role.index',
                        'permission_name' => 'role_index',
                        'position' => 5,
                    ],
                    [
                        'name' => 'Permission Management',
                        'icon' => 'ri-shield-star-line',
                        'route' => 'permission.index',
                        'permission_name' => 'permission_index',
                        'position' => 6,
                    ],
                ],
            ],
        ];

        // Create Menu Groups and Items
        foreach ($menuGroups as $groupData) {
            $menuGroup = MenuGroup::create([
                'name' => $groupData['name'],
                'permission_name' => $groupData['permission_name'],
                'position' => $groupData['position'],
            ]);

            foreach ($groupData['items'] as $itemData) {
                MenuItem::create([
                    'name' => $itemData['name'],
                    'icon' => $itemData['icon'],
                    'route' => $itemData['route'],
                    'permission_name' => $itemData['permission_name'],
                    'menu_group_id' => $menuGroup->id,
                    'position' => $itemData['position'],
                ]);
            }
        }
    }
}