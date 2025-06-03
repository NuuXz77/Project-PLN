<?php

namespace Database\Seeders;

use AdminSeeder;
use Database\Seeders\AdminSeeder as SeedersAdminSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SeedersAdminSeeder::class,
        ]);
    }
}
