<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\MenuGroup;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $menuGroups = [
            [
                'name' => 'Klasifikasi Arsip',
                'permission_name' => 'classification',
                'position' => 4,
                'items' => [
                    [
                        'name' => 'Klasifikasi Utama',
                        'icon' => 'ri-git-merge-line',
                        'route' => 'backsite.main-classification.index',
                        'permission_name' => 'main_classification_index',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Sub Klasifikasi',
                        'icon' => 'ri-archive-stack-fill',
                        'route' => 'backsite.sub-classification.index',
                        'permission_name' => 'sub_classification_index',
                        'position' => 2,
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
