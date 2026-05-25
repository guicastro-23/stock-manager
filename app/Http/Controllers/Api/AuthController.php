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

    public function login(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::whereHas('funcionario', function ($query) use ($dados) {
            $query->where('email', $dados['email']);
        })->with('funcionario')->first();

        if (!$user || !Hash::check($dados['password'], $user->password)) {

            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        $token = $user->createToken('api-token')
            ->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso.',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()->load('funcionario')
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ]);
    }

}
