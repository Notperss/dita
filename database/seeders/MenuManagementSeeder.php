<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        $this->call(MenuGeneralSeederTableSeeder::class);
        $this->call(MenuTransactionArchiveSeeder::class);
        $this->call(MenuLocationSeeder::class);
        $this->call(MenuClassificationSeeder::class);
        $this->call(MenuSettingSeederTableSeeder::class);
    }
}
