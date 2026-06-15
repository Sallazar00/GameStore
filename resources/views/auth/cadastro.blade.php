@extends('layouts.app', ['titulo' => 'Cadastro de Cliente'])

@section('conteudo')
<main class="container">
    <div class="box">
        <h1>Cadastro de Cliente</h1>
        <p>Este cadastro é destinado a usuários clientes.</p>

        <form method="POST" action="{{ route('cadastro.salvar') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome</label>
                    <input name="nome" class="form-control" value="{{ old('nome') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">CPF</label>
                    <input name="cpf" class="form-control" value="{{ old('cpf') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">RG</label>
                    <input name="rg" class="form-control" value="{{ old('rg') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Data de nascimento</label>
                    <input name="data_nascimento" type="date" class="form-control" value="{{ old('data_nascimento') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Telefone</label>
                    <input name="telefone" class="form-control" value="{{ old('telefone') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">E-mail</label>
                    <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Senha</label>
                    <input name="senha" type="password" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirmar senha</label>
                    <input name="senha_confirmation" type="password" class="form-control" required>
                </div>
            </div>

            <button class="btn btn-success">Cadastrar</button>
            <a href="{{ route('login') }}" class="btn btn-outline-light">Já tenho login</a>
        </form>
    </div>
</main>
@endsection
