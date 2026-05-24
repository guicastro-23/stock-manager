<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        return response()->json(
            Produto::all()
        );
    }


    public function store(Request $request)
    {
        $dados = $request->validate([
            'codigo_sistema' => 'required|string|max:100|unique:produtos,codigo_sistema',
            'nome' => 'required|string|max:255',
        ]);

        $produto = Produto::create($dados);

        return response()->json([
            'message' => 'Produto criado com sucesso.',
            'produto' => $produto,
        ], 201);
    }

    public function show(string $id)
    {
        $produto = Produto::findOrFail($id);

        return response()->json($produto);
    }

    public function update(Request $request, string $id)
    {
        $dados = $request->validate([
            'codigo_sistema' => 'required|string|max:100|unique:produtos,codigo_sistema,' . $id,
            'nome' => 'required|string|max:255',
        ]);

        $produto = Produto::findOrFail($id);

        $produto->update($dados);

        return response()->json([
            'message' => 'Produto atualizado com sucesso.',
            'produto' => $produto,
        ]);
    }

    public function destroy(string $id)
    {
        $produto = Produto::findOrFail($id);

        $produto->delete();

        return response()->json([
            'message' => 'Produto removido com sucesso.'
        ]);
    }

    public function buscar(Request $request)
    {
        $busca = $request->query('busca');

        $produtos = Produto::query()
            ->where('nome', 'like', "%{$busca}%")
            ->orWhere('codigo_sistema', 'like', "%{$busca}%")
            ->get();

        return response()->json($produtos);
    }


}