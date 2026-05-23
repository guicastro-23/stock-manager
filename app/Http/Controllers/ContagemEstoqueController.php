<?php

namespace App\Http\Controllers;

use App\Models\ContagemEstoque;
use App\Models\EstoqueProduto;
use App\Models\Funcionario;
//use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContagemEstoqueRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ContagemEstoqueController extends Controller
{
    public function show(ContagemEstoque $contagem)
    {
        $contagem->load([
            'responsavel',
            'itens.produto',
        ]);

        return Inertia::render('Contagens/Show', [
            'contagem' => $contagem,
        ]);
    }

    public function updateStatus(Request $request, ContagemEstoque $contagem)
    {
        $data = $request->validate([
            'status' => ['required', 'in:EM_ANDAMENTO,FINALIZADA'],
        ]);

        $contagem->forceFill([
            'status' => $data['status'],
            'updated_at' => now(),
        ])->save();
        
        return back();
    }

    public function create()
    {
        $funcionarios = Funcionario::select('id', 'nome')
            ->orderBy('nome')
            ->get();

        return Inertia::render('Contagens/Create', [
            'funcionarios' => $funcionarios,
        ]);
    }

    public function store(StoreContagemEstoqueRequest $request)
    {
        $data = $request->validated();

        $contagem = DB::transaction(function () use ($data) {
        $ultimoCodigo = ContagemEstoque::query()
            ->selectRaw('MAX(CAST(codigo AS INTEGER)) as ultimo_codigo')
            ->value('ultimo_codigo');

        $novoCodigo = $ultimoCodigo && $ultimoCodigo >= 1073
            ? $ultimoCodigo + 1
            : 1074;

        $contagem = ContagemEstoque::create([
            'codigo' => $novoCodigo,
            'responsavel_id' => $data['responsavel_id'],
            'data_agendada' => $data['data_agendada'],
            'status' => 'EM_ANDAMENTO',
        ]);

        $estoquesProdutos = EstoqueProduto::all();

            foreach ($estoquesProdutos as $estoqueProduto) {
                $contagem->itens()->create([
                    'produto_id' => $estoqueProduto->produto_id,
                    'quantidade_sistema' => $estoqueProduto->quantidade_sistema,
                    'quantidade_contada' => null,
                    'situacao' => 'A_CONFERIR',
                    'observacao' => null,
                ]);
            }

            return $contagem;
        });

        return redirect()->route('contagens.show', $contagem->id);
    }
}