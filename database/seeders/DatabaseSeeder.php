<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {
        $this->call([
            LocationSeeder::class, 
            CctvSeeder::class, 
            ContactSeeder::class,
            UserSeeder::class,
            NewsSeeder::class
        ]);
    }
}
