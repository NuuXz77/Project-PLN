<?php

namespace Database\Seeders; // ✅ tambahkan baris ini

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'no_user' => 'ADM01',
            'name' => 'Super Udin',
            'email' => 'udin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
