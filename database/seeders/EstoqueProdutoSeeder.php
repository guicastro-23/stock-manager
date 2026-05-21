<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstoqueProduto;

class EstoqueProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estoques = [
            ['produto_id' => 1, 'quantidade_sistema' => 25],
            ['produto_id' => 2, 'quantidade_sistema' => 50],
            ['produto_id' => 3, 'quantidade_sistema' => 30],
            ['produto_id' => 4, 'quantidade_sistema' => 15],
            ['produto_id' => 5, 'quantidade_sistema' => 40],
            ['produto_id' => 6, 'quantidade_sistema' => 35],
            ['produto_id' => 7, 'quantidade_sistema' => 60],
            ['produto_id' => 8, 'quantidade_sistema' => 80],
            ['produto_id' => 9, 'quantidade_sistema' => 45],
            ['produto_id' => 10, 'quantidade_sistema' => 100],
        ];

        foreach ($estoques as $estoque) {
            EstoqueProduto::create($estoque);
        }
    }
}