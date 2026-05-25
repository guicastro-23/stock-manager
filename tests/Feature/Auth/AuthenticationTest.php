<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Funcionario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tela_de_login_pode_ser_renderizada(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_usuario_pode_autenticar_no_sistema(): void
    {
        $funcionario = Funcionario::create([
            'nome' => 'Carlos Santos',
            'email' => 'carlos@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::create([
            'funcionario_id' => $funcionario->id,
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $funcionario->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_usuario_nao_pode_autenticar_com_senha_invalida(): void
    {
        $funcionario = Funcionario::create([
            'nome' => 'Carlos Santos',
            'email' => 'carlos@example.com',
        ]);

        User::create([
            'funcionario_id' => $funcionario->id,
            'password' => Hash::make('password123'),
        ]);

        $this->post('/login', [
            'email' => $funcionario->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_usuario_pode_realizar_logout(): void
    {
        $funcionario = Funcionario::create([
            'nome' => 'Carlos Santos',
            'email' => 'carlos@example.com',
        ]);

        $user = User::create([
            'funcionario_id' => $funcionario->id,
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();

        $response->assertRedirect('/');
    }
}