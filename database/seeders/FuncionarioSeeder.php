<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funcionario = Funcionario::create([
            'nome' => 'João Silva',
            'email' => 'joao.silva@example.com',
        ]);

        User::create([
            'funcionario_id' => $funcionario->id,
            'password' => Hash::make('password123'),
        ]);
    }
}
