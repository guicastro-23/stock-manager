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
    public function index(Request $request)
        {   
            $query = ContagemEstoque::query()
                ->with('responsavel')
                ->withCount('itens');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('responsavel_id')) {
                $query->where('responsavel_id', $request->responsavel_id);
            }

            if ($request->filled('data_inicio')) {
                $query->whereDate('data_agendada', '>=', $request->data_inicio);
            }

            if ($request->filled('data_fim')) {
                $query->whereDate('data_agendada', '<=', $request->data_fim);
            }

            $contagens = $query
                ->orderByDesc('data_agendada')
                ->get();


            return Inertia::render('Contagens/Index', [
                'contagens' => $contagens,
            ]);
    }


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

    public function destroy($id)
    {
        $contagem = ContagemEstoque::findOrFail($id);

        if ($contagem->status === 'FINALIZADA') {
            return redirect()->back()
                ->with('error', 'Não é possível excluir uma contagem finalizada.');
        }

        $contagem->delete();

        return redirect()->back()
            ->with('success', 'Contagem excluída com sucesso.');
    }
}