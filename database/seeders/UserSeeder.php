<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Vrai',
            'email' => 'admin@cariwisata.id',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User Biasa',
            'email' => 'user@cariwisata.id',
            'password' => bcrypt('user123'),
            'role' => 'user',
        ]);
    }
}

