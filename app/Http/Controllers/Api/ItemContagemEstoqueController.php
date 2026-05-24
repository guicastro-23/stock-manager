<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContagemEstoque;
use App\Models\ItemContagemEstoque;
use Illuminate\Http\Request;

class ItemContagemEstoqueController extends Controller
{
    public function index(int $contagemId)
    {
        $contagem = ContagemEstoque::with([
            'itens.produto'
        ])->findOrFail($contagemId);

        return response()->json($contagem->itens);
    }

    public function situacao(int $contagemId)
    {
        $contagem = ContagemEstoque::with([
            'itens.produto'
        ])->findOrFail($contagemId);

        $itensAgrupados = $contagem->itens
            ->groupBy('situacao');

        return response()->json([
            'A_CONFERIR' => $itensAgrupados->get('A_CONFERIR', []),
            'CONFERIDO' => $itensAgrupados->get('CONFERIDO', []),
            'FALTANTE_EXCEDENTE' => $itensAgrupados->get('FALTANTE_EXCEDENTE', []),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $dados = $request->validate([
            'quantidade_contada' => 'required|integer|min:0',
            'observacao' => 'nullable|string',
        ]);

        $item = ItemContagemEstoque::findOrFail($id);

        $item->quantidade_contada = $dados['quantidade_contada'];
        $item->observacao = $dados['observacao'] ?? null;

        if ($item->quantidade_contada == $item->quantidade_sistema) {
            $item->situacao = 'CONFERIDO';
        } else {
            $item->situacao = 'FALTANTE_EXCEDENTE';
        }

        $item->save();

        return response()->json([
            'message' => 'Item atualizado com sucesso.',
            'item' => $item,
        ]);
    }
}