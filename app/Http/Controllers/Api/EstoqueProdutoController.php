<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EstoqueProduto;
use Illuminate\Http\Request;

class EstoqueProdutoController extends Controller
{
    public function index()
    {
        $estoques = EstoqueProduto::with('produto')->get();

        return response()->json($estoques);
    }


    public function show(int $produto)
    {
        $estoque = EstoqueProduto::with('produto')
            ->where('produto_id', $produto)
            ->first();

        if (!$estoque) {
            return response()->json([
                'message' => 'Estoque do produto não encontrado.'
            ], 404);
        }

        return response()->json($estoque);
    }

    public function update(Request $request, int $produto)
    {
        $dados = $request->validate([
            'quantidade_sistema' => 'required|integer|min:0',
        ]);

        $estoque = EstoqueProduto::where('produto_id', $produto)
            ->first();

        if (!$estoque) {
            return response()->json([
                'message' => 'Estoque do produto não encontrado.'
            ], 404);
        }

        $estoque->update([
            'quantidade_sistema' => $dados['quantidade_sistema']
        ]);

        return response()->json([
            'message' => 'Estoque atualizado com sucesso.',
            'estoque' => $estoque
        ]);
    }


}