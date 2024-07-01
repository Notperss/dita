<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
        ]);

        User::factory()->create([
            'name' => 'Admin-divisi',
            'email' => 'admin-divisi@mail.com',
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@mail.com',
        ]);

        User::factory()->create([
            'name' => 'User-divisi',
            'email' => 'user-divisi@mail.com',
        ]);
    }
}
