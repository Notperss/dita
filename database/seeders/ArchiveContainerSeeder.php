<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArchiveContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        \App\Models\TransactionArchive\Archive\ArchiveContainer::factory(100)->create();
    }
}
