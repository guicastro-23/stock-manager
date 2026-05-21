<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'funcionario_id' => 1,
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'funcionario_id' => 2,
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'funcionario_id' => 3,
            'password' => Hash::make('password123'),
        ]);
    }
}