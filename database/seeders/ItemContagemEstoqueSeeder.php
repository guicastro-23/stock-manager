<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemContagemEstoque;

class ItemContagemEstoqueSeeder extends Seeder
{
    public function run(): void
    {
        // CONTAGEM 1071
        ItemContagemEstoque::create([
            'contagem_estoque_id' => 1,
            'produto_id' => 1,
            'quantidade_sistema' => 25,
            'quantidade_contada' => null,
            'situacao' => 'A_CONFERIR',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 1,
            'produto_id' => 2,
            'quantidade_sistema' => 50,
            'quantidade_contada' => null,
            'situacao' => 'A_CONFERIR',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 1,
            'produto_id' => 3,
            'quantidade_sistema' => 30,
            'quantidade_contada' => null,
            'situacao' => 'A_CONFERIR',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 1,
            'produto_id' => 4,
            'quantidade_sistema' => 15,
            'quantidade_contada' => 15,
            'situacao' => 'CONFERIDO',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 1,
            'produto_id' => 5,
            'quantidade_sistema' => 40,
            'quantidade_contada' => 40,
            'situacao' => 'CONFERIDO',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 1,
            'produto_id' => 6,
            'quantidade_sistema' => 35,
            'quantidade_contada' => 32,
            'situacao' => 'FALTANTE_EXCEDENTE',
            'observacao' => '3 unidades danificadas encontradas no estoque',
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 1,
            'produto_id' => 7,
            'quantidade_sistema' => 60,
            'quantidade_contada' => 65,
            'situacao' => 'FALTANTE_EXCEDENTE',
            'observacao' => 'Entrada não registrada no sistema - produtos recebidos mas não lançados',
        ]);

        // CONTAGEM 1072
        ItemContagemEstoque::create([
            'contagem_estoque_id' => 2,
            'produto_id' => 1,
            'quantidade_sistema' => 25,
            'quantidade_contada' => 25,
            'situacao' => 'CONFERIDO',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 2,
            'produto_id' => 2,
            'quantidade_sistema' => 50,
            'quantidade_contada' => 48,
            'situacao' => 'FALTANTE_EXCEDENTE',
            'observacao' => '2 unidades vendidas mas não baixadas do estoque',
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 2,
            'produto_id' => 8,
            'quantidade_sistema' => 80,
            'quantidade_contada' => 80,
            'situacao' => 'CONFERIDO',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 2,
            'produto_id' => 9,
            'quantidade_sistema' => 45,
            'quantidade_contada' => 45,
            'situacao' => 'CONFERIDO',
            'observacao' => null,
        ]);

        // CONTAGEM 1073
        ItemContagemEstoque::create([
            'contagem_estoque_id' => 3,
            'produto_id' => 3,
            'quantidade_sistema' => 30,
            'quantidade_contada' => 30,
            'situacao' => 'CONFERIDO',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 3,
            'produto_id' => 4,
            'quantidade_sistema' => 15,
            'quantidade_contada' => null,
            'situacao' => 'A_CONFERIR',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 3,
            'produto_id' => 5,
            'quantidade_sistema' => 40,
            'quantidade_contada' => null,
            'situacao' => 'A_CONFERIR',
            'observacao' => null,
        ]);

        ItemContagemEstoque::create([
            'contagem_estoque_id' => 3,
            'produto_id' => 10,
            'quantidade_sistema' => 100,
            'quantidade_contada' => 98,
            'situacao' => 'FALTANTE_EXCEDENTE',
            'observacao' => '2 unidades com defeito de fabricação',
        ]);
    }
}