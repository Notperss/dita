<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\MenuGroup;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuTransactionArchiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $menuGroups = [
            [
                'name' => 'Transaksi Arsip',
                'permission_name' => 'transaksi arsip',
                'position' => 2,
                'items' => [
                    [
                        'name' => 'Penyimpanan Arsip',
                        'icon' => 'ri-archive-drawer-line',
                        'route' => 'backsite.archive-container.index',
                        'permission_name' => 'archive_container_index',
                        'position' => 1,
                    ],
                    [
                        'name' => 'Peminjaman Arsip',
                        'icon' => 'ri-mail-send-fill',
                        'route' => 'backsite.lending-archive.index',
                        'permission_name' => 'lending_archive_index',
                        'position' => 2,
                    ],
                    [
                        'name' => 'Pemusnahan Arsip',
                        'icon' => 'ri-file-shred-fill',
                        'route' => 'backsite.destruction-archive.index',
                        'permission_name' => 'destruction_archive',
                        'position' => 3,
                    ],
                    [
                        'name' => 'Folder Divisi',
                        'icon' => 'ri-hard-drive-3-fill',
                        'route' => 'backsite.folder.index',
                        'permission_name' => 'folder_division',
                        'position' => 4,
                    ],
                    [
                        'name' => 'Arsip',
                        'icon' => 'ri-archive-line',
                        'route' => 'backsite.dataArchive',
                        'permission_name' => 'all_archive',
                        'position' => 5,
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
