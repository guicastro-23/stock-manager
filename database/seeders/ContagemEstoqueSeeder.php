<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContagemEstoque;

class ContagemEstoqueSeeder extends Seeder
{
    public function run(): void
    {
        ContagemEstoque::create([
            'codigo' => '1071',
            'data_agendada' => '2025-11-20',
            'responsavel_id' => 1,
            'status' => 'EM_ANDAMENTO',
        ]);

        ContagemEstoque::create([
            'codigo' => '1072',
            'data_agendada' => '2025-11-18',
            'responsavel_id' => 2,
            'status' => 'FINALIZADA',
        ]);

        ContagemEstoque::create([
            'codigo' => '1073',
            'data_agendada' => '2025-11-25',
            'responsavel_id' => 3,
            'status' => 'EM_ANDAMENTO',
        ]);
    }
}