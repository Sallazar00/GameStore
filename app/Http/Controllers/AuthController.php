<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function cadastroForm()
    {
        return view('auth.cadastro');
    }

    public function cadastrar(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:20|unique:clientes,cpf',
            'rg' => 'required|string|max:30',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:30',
            'email' => 'required|email|unique:clientes,email',
            'senha' => 'required|string|min:3|confirmed',
        ]);

        $dados['senha'] = Hash::make($dados['senha']);
        $dados['tipo'] = 'cliente';

        Cliente::create($dados);

        return redirect('/login')->with('sucesso', 'Cadastro realizado! Agora faça login.');
    }

    public function entrar(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'senha' => 'required|string',
        ]);

        // Administrador de demonstração para facilitar a apresentação.
        if ($request->email === 'admin@gamestore.com' && $request->senha === '123456') {
            session([
                'cliente_id' => 0,
                'cliente_nome' => 'Administrador',
                'cliente_email' => 'admin@gamestore.com',
                'cliente_tipo' => 'admin',
            ]);

            return redirect('/admin')->with('sucesso', 'Login de administrador realizado.');
        }

        $cliente = Cliente::where('email', $request->email)->first();

        if (!$cliente || !Hash::check($request->senha, $cliente->senha)) {
            return back()->with('erro', 'E-mail ou senha inválidos.');
        }

        session([
            'cliente_id' => $cliente->id,
            'cliente_nome' => $cliente->nome,
            'cliente_email' => $cliente->email,
            'cliente_tipo' => $cliente->tipo,
        ]);

        return redirect('/')->with('sucesso', 'Login realizado com sucesso.');
    }

    public function sair()
    {
<<<<<<< HEAD
        session()->forget(['cliente_id', 'cliente_nome', 'cliente_email', 'cliente_tipo', 'carrinho', 'checkout_token']);
=======
        session()->forget(['cliente_id', 'cliente_nome', 'cliente_email', 'cliente_tipo', 'carrinho']);
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
        return redirect('/')->with('sucesso', 'Você saiu da sua conta.');
    }
}
