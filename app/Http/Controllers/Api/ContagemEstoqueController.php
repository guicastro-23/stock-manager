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
}