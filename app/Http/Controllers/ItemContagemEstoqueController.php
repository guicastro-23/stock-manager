<?php

namespace App\Http\Controllers;

use App\Models\ItemContagemEstoque;
use Illuminate\Http\Request;

class ItemContagemEstoqueController extends Controller
{
   public function update(Request $request, ItemContagemEstoque $item)
    {
        if ($item->contagemEstoque->status === 'FINALIZADA') {
            return back()->withErrors([
                'item' => 'Esta conferência já foi finalizada e não pode ser editada.',
            ]);
        }   

        $data = $request->validate([
            'quantidade_contada' => ['required', 'integer', 'min:0'],
            'observacao' => ['nullable', 'string'],
        ]);

        $situacao = $data['quantidade_contada'] == $item->quantidade_sistema
            ? 'CONFERIDO'
            : 'FALTANTE_EXCEDENTE';

        $item->update([
            'quantidade_contada' => $data['quantidade_contada'],
            'situacao' => $situacao,
            'observacao' => $data['observacao'] ?? null,
        ]);

        return back();
    }

    public function updateObservacao(Request $request, ItemContagemEstoque $item)
    {
        if ($item->contagemEstoque->status === 'FINALIZADA') {
            return back()->withErrors([
                'item' => 'Esta conferência já foi finalizada.',
            ]);
        }

        $data = $request->validate([
            'observacao' => ['required', 'string'],
        ]);

        $item->update([
            'observacao' => $data['observacao'],
        ]);

        return back();
    }
}