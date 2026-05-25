<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produto;
use App\Models\Funcionario;
use App\Models\EstoqueProduto;
use App\Models\ContagemEstoque;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContagemEstoqueTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_criar_conferencia(): void
    {
        $funcionario = Funcionario::create([
            'nome' => 'Carlos Santos',
            'email' => 'carlos@example.com',
        ]);

        $produto = Produto::firstOrCreate(
            [
                'codigo_sistema' => 'PROD-001',
            ],
            [
                'nome' => 'Notebook Dell Inspiron 15',
            ]
        );

        EstoqueProduto::updateOrCreate(
            [
                'produto_id' => $produto->id,
            ],
            [
                'quantidade_sistema' => 10,
            ]
        );

        $user = User::create([
            'funcionario_id' => $funcionario->id,
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->post('/contagens-estoque', [
            'responsavel_id' => $funcionario->id,
            'data_agendada' => '2026-06-10',
        ]);

        $contagem = ContagemEstoque::latest('id')->first();

        $this->assertNotNull($contagem);

        $this->assertEquals('EM_ANDAMENTO', $contagem->status);

        $this->assertEquals(
            $funcionario->id,
            $contagem->responsavel_id
        );

        $this->assertDatabaseHas('itens_contagem_estoque', [
            'contagem_estoque_id' => $contagem->id,
            'produto_id' => $produto->id,
            'quantidade_sistema' => 10,
            'quantidade_contada' => null,
            'situacao' => 'A_CONFERIR',
            'observacao' => null,
        ]);

        $response->assertRedirect(
            route('contagens.show', $contagem->id)
        );
    }
}