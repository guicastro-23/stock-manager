<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::all();

        return response()->json($funcionarios);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:funcionarios,email',
        ]);

        $funcionario = Funcionario::create($dados);

        return response()->json([
            'message' => 'Funcionário criado com sucesso.',
            'funcionario' => $funcionario,
        ], 201);
    }

    public function show(string $id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json([
                'message' => 'Funcionário não encontrado.'
            ], 404);
        }

        return response()->json($funcionario);
    }

    public function update(Request $request, string $id)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:funcionarios,email,' . $id,
        ]);

        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json([
                'message' => 'Funcionário não encontrado.'
            ], 404);
        }

        $funcionario->update($dados);

        return response()->json([
            'message' => 'Funcionário atualizado com sucesso.',
            'funcionario' => $funcionario
        ]);
    }

    public function destroy(string $id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json([
                'message' => 'Funcionário não encontrado.'
            ], 404);
        }

        $funcionario->delete();

        return response()->json([
            'message' => 'Funcionário removido com sucesso.'
        ]);
    }

}
