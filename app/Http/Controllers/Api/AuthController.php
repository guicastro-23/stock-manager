<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registrar(Request $request)
    {
        $dados = $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'funcionario_id' => $dados['funcionario_id'],
            'password' => Hash::make($dados['password']),
        ]);

        return response()->json([
            'message' => 'Usuário registrado com sucesso.',
            'user' => $user,
        ], 201);
    }
}
