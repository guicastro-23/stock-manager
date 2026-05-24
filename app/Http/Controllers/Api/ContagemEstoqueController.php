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
}