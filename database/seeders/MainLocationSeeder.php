<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        \App\Models\MasterData\Location\MainLocation::factory(40)->create();
    }
}
