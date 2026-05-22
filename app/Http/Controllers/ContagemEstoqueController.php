<?php

namespace App\Http\Controllers;

use App\Models\ContagemEstoque;
use Illuminate\Http\Request;
use Inertia\Inertia;

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


}