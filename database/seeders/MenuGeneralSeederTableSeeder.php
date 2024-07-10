<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuGroup;
use App\Models\MenuItem;

class MenuGeneralSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // $general = MenuGroup::create([
        //     'name' => 'Menu',
        //     'permission_name' => 'general',
        //     'position' => 1,
        // ]);

        // MenuItem::create([
        //     'name' => 'Dashboard',
        //     'icon' => 'ri-dashboard-2-line',
        //     'route' => 'dashboard.index',
        //     'permission_name' => 'dashboard_index',
        //     'menu_group_id' => $general->id,
        //     'position' => 1,
        // ]);
        // MenuItem::create([
        //     'name' => 'Perusahaan',
        //     'icon' => 'ri-building-4-fill',
        //     'route' => 'company.index',
        //     'permission_name' => 'company_index',
        //     'menu_group_id' => $general->id,
        //     'position' => 2,
        // ]);
        // MenuItem::create([
        //     'name' => 'Divisi',
        //     'icon' => 'ri-group-line',
        //     'route' => 'division.index',
        //     'permission_name' => 'division_index',
        //     'menu_group_id' => $general->id,
        //     'position' => 3,
        // ]);

        $menuGroups = [
            [
                'name' => 'Menu',
                'permission_name' => 'general',
                'position' => 1,
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => 'ri-dashboard-2-line',
                        'route' => 'dashboard.index',
                        'permission_name' => 'dashboard_index',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Perusahaan',
                        'icon' => 'ri-building-4-fill',
                        'route' => 'company.index',
                        'permission_name' => 'company_index',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Divisi',
                        'icon' => 'ri-group-line',
                        'route' => 'division.index',
                        'permission_name' => 'division_index',
                        'position' => 3,
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
