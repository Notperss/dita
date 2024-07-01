<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\MenuGroup;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $menuGroups = [
            [
                'name' => 'Lokasi',
                'permission_name' => 'location',
                'position' => 3,
                'items' => [
                    [
                        'name' => 'Lokasi Utama',
                        'icon' => 'ri-map-pin-line',
                        'route' => 'backsite.main-location.index',
                        'permission_name' => 'main_location_index',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Sub Lokasi',
                        'icon' => 'ri-map-pin-2-line',
                        'route' => 'backsite.sub-location.index',
                        'permission_name' => 'sub_location_index',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Detail Lokasi',
                        'icon' => 'ri-map-pin-3-line',
                        'route' => 'backsite.detail-location.index',
                        'permission_name' => 'detail_location_index',
                        'position' => 3,
                    ],
                    [
                        'name' => 'Container',
                        'icon' => 'ri-box-3-line',
                        'route' => 'backsite.container-location.index',
                        'permission_name' => 'container_location_index',
                        'position' => 4,
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
