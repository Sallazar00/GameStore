@extends('layouts.app', ['titulo' => 'Login'])

@section('conteudo')
<main class="container">
    <div class="box mx-auto" style="max-width:560px">
        <h1>Login</h1>
        <p class="text-light">
            Admin de teste: <strong>admin@gamestore.com</strong> / <strong>123456</strong>
        </p>

        <form method="POST" action="{{ route('login.entrar') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input name="senha" type="password" class="form-control" required>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-primary">Entrar</button>
                <a href="{{ route('cadastro') }}" class="btn btn-success">Cadastrar cliente</a>
            </div>
        </form>
    </div>
</main>
@endsection
