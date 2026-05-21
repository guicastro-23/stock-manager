<?php

namespace Database\Seeders;

use App\Models\Funcionario;
//use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\Hash;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Funcionario::insert([
            ['nome' => 'João Silva', 'email' => 'joao.silva@example.com'],
            ['nome' => 'Maria Souza', 'email' => 'maria.souza@example.com'],
            ['nome' => 'Carlos Santos', 'email' => 'carlos.santos@example.com'],
            ['nome' => 'Ana Costa', 'email' => 'ana.costa@example.com'],
        ]);
    }
}
