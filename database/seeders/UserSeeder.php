<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Create regular users
        User::create([
            'name' => 'Petugas 1',
            'username' => 'petugas1',
            'password' => Hash::make('petugas123'),
        ]);

        User::create([
            'name' => 'Petugas 2',
            'username' => 'petugas2',
            'password' => Hash::make('petugas123'),
        ]);

        User::create([
            'name' => 'Operator',
            'username' => 'operator',
            'password' => Hash::make('operator123'),
        ]);
    }
}
