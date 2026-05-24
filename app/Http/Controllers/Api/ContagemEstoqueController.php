<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContagemEstoque;
use Illuminate\Http\Request;

class ContagemEstoqueController extends Controller
{
    public function index(Request $request)
    {
        $contagens = ContagemEstoque::query()
            ->with('responsavel')
            ->withCount('itens')
            ->orderByDesc('data_agendada')
            ->get();

        return response()->json($contagens);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'codigo' => 'required',
            'data_agendada' => 'required|date',
            'responsavel_id' => 'required',
        ]);

        $dados['status'] = 'EM_ANDAMENTO';

        $contagem = ContagemEstoque::create($dados);

        return response()->json($contagem, 201);
    }

    public function show($id)
    {
        $contagem = ContagemEstoque::with([
            'responsavel',
            'itens.produto',
        ])->findOrFail($id);

        $itensAgrupados = $contagem->itens->groupBy('situacao');

        return response()->json([
            'contagem' => [
            'id' => $contagem->id,
            'codigo' => $contagem->codigo,
            'data_agendada' => $contagem->data_agendada,
            'status' => $contagem->status,
            'responsavel' => $contagem->responsavel,
            ],
                'itens_por_situacao' => $itensAgrupados,
            ]);
    }

    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'codigo' => 'required|string|max:255',
            'data_agendada' => 'required|date',
            'responsavel_id' => 'required|exists:funcionarios,id',
            'status' => 'required|string',
        ]);

        $contagem = ContagemEstoque::findOrFail($id);

        $contagem->update($dados);

        return response()->json([
            'message' => 'Contagem atualizada com sucesso',
            'contagem' => $contagem,
        ]);
    }

    public function destroy($id)
    {
        $contagem = ContagemEstoque::findOrFail($id);

        // só pode excluir se não estiver finalizada

        if ($contagem->status === 'FINALIZADA') {
            return response()->json([
                'message' => 'Não é possível excluir uma contagem finalizada.'
            ], 400);
        }

        $contagem->delete();

        return response()->json([
            'message' => 'Contagem excluída com sucesso.'
        ]);

    }

    public function updateStatus(Request $request, $id)
    {
        $dados = $request->validate([
            'status' => 'required|in:EM_ANDAMENTO,FINALIZADA',
        ]);

        $contagem = ContagemEstoque::findOrFail($id);

        $contagem->status = $dados['status'];

        $contagem->save();

        return response()->json([
        'id' => $contagem->id,
        'codigo' => $contagem->codigo,
        'status' => $contagem->status,
        'message' => $contagem->status === 'FINALIZADA'
            ? 'Contagem de estoque finalizada com sucesso.'
            : 'Contagem salva como em andamento.'
        ]);
    }

    
}