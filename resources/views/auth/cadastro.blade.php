@extends('layouts.app', ['titulo' => 'Criar Conta'])

@section('conteudo')
<main class="auth-section">
    <div class="container">
        <div class="auth-shell">
            <div class="row g-0">
                <div class="col-lg-4">
                    <div class="auth-visual h-100">
                        <div class="auth-visual__content">
                            <span class="auth-visual__icon"><i class="bi bi-person-plus"></i></span>
                            <h2>Monte sua biblioteca.</h2>
                            <p>Crie uma conta para comprar jogos digitais e manter todos os títulos organizados na sua biblioteca.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="auth-form">
                        <span class="section-kicker">Nova conta</span>
                        <h1>Cadastro de cliente</h1>
                        <p>Preencha os dados abaixo para começar.</p>

                        <form method="POST" action="{{ route('cadastro.salvar') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome completo</label>
                                    <input id="nome" name="nome" class="form-control" value="{{ old('nome') }}" placeholder="Seu nome" autocomplete="name" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input id="cpf" name="cpf" class="form-control" value="{{ old('cpf') }}" placeholder="000.000.000-00" inputmode="numeric" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="rg" class="form-label">RG</label>
                                    <input id="rg" name="rg" class="form-control" value="{{ old('rg') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="data_nascimento" class="form-label">Data de nascimento</label>
                                    <input id="data_nascimento" name="data_nascimento" type="date" class="form-control" value="{{ old('data_nascimento') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input id="telefone" name="telefone" class="form-control" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" inputmode="tel" autocomplete="tel" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" placeholder="voce@email.com" autocomplete="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="senha" class="form-label">Senha</label>
                                    <input id="senha" name="senha" type="password" class="form-control" placeholder="Mínimo de 3 caracteres" autocomplete="new-password" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="senha_confirmation" class="form-label">Confirmar senha</label>
                                    <input id="senha_confirmation" name="senha_confirmation" type="password" class="form-control" placeholder="Repita sua senha" autocomplete="new-password" required>
                                </div>
                            </div>
                            <button class="btn btn-success w-100 btn-lg mt-4"><i class="bi bi-person-check me-2"></i>Criar minha conta</button>
                        </form>

                        <p class="text-center mt-4 mb-0 text-muted-custom">Já possui uma conta? <a href="{{ route('login') }}" class="text-white fw-bold">Entrar agora</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
