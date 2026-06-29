@extends('layouts.app', ['titulo' => 'Entrar'])

@section('conteudo')
<main class="auth-section">
    <div class="container">
        <div class="auth-shell">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="auth-visual h-100">
                        <div class="auth-visual__content">
                            <span class="auth-visual__icon"><i class="bi bi-controller"></i></span>
                            <h2>Entre no jogo.</h2>
                            <p>Acesse sua conta para acompanhar compras, administrar endereços e abrir sua biblioteca pessoal.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="auth-form">
                        <span class="section-kicker">Bem-vindo de volta</span>
                        <h1>Entrar na GameStore</h1>
                        <p>Use seu e-mail e senha para continuar.</p>

                        <div class="demo-login">
                            <i class="bi bi-info-circle-fill"></i>
                            <div><strong>Acesso de demonstração do administrador</strong><br>E-mail: admin@gamestore.com &nbsp;|&nbsp; Senha: 123456</div>
                        </div>

                        <form method="POST" action="{{ route('login.entrar') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <div class="position-relative">
                                    <i class="bi bi-envelope position-absolute top-50 translate-middle-y ms-3 text-muted-custom"></i>
                                    <input id="email" name="email" type="email" class="form-control ps-5" value="{{ old('email') }}" placeholder="voce@email.com" autocomplete="email" required autofocus>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="senha" class="form-label">Senha</label>
                                <div class="position-relative">
                                    <i class="bi bi-lock position-absolute top-50 translate-middle-y ms-3 text-muted-custom"></i>
                                    <input id="senha" name="senha" type="password" class="form-control ps-5" placeholder="Digite sua senha" autocomplete="current-password" required>
                                </div>
                            </div>
                            <button class="btn btn-success w-100 btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Entrar</button>
                        </form>

                        <p class="text-center mt-4 mb-0 text-muted-custom">Ainda não tem conta? <a href="{{ route('cadastro') }}" class="text-white fw-bold">Cadastre-se gratuitamente</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
