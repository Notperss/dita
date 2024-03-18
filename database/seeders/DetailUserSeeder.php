<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ManagementAccess\DetailUser;

class DetailUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail_user = [
            [
                'user_id' => 1,
                'type_user_id' => 1,
                'status' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DetailUser::insert($detail_user);
    }
}
