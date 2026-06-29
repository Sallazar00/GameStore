<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GameStore — sua loja de jogos digitais.">
    <meta name="theme-color" content="#080d18">
    <title>{{ $titulo ?? 'GameStore' }} | GameStore</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/store.css') }}" rel="stylesheet">
</head>
<body data-placeholder="{{ asset('images/placeholder-game.svg') }}">
@php
    $cartCount = collect(session('carrinho', []))->sum(fn ($item) => (int) ($item['quantidade'] ?? 0));
@endphp

<div class="promo-bar">
    <div class="container promo-bar__content">
        <span><i class="bi bi-lightning-charge-fill"></i> Ofertas especiais em jogos digitais</span>
        <span class="d-none d-md-inline"><i class="bi bi-shield-check"></i> Compra segura e acesso rápido</span>
    </div>
</div>

<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-dark py-0">
        <div class="container header-inner">
            <a class="brand" href="{{ route('home') }}" aria-label="Página inicial GameStore">
                <span class="brand__mark"><i class="bi bi-controller"></i></span>
                <span class="brand__text">GAME<span>STORE</span></span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGameStore" aria-controls="navbarGameStore" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarGameStore">
                <form method="GET" action="{{ route('home') }}" class="header-search order-lg-2" role="search">
                    <i class="bi bi-search"></i>
                    <input name="busca" value="{{ request('busca') }}" type="search" placeholder="Qual jogo você procura?" aria-label="Pesquisar jogos">
                    <button type="submit">Buscar</button>
                </form>

                <ul class="navbar-nav main-nav order-lg-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Loja</a>
                    </li>
                    @if(session('cliente_tipo') === 'cliente')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('biblioteca') ? 'active' : '' }}" href="{{ route('biblioteca') }}">Biblioteca</a>
                        </li>
                    @endif
                    @if(session('cliente_tipo') === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin*') ? 'active' : '' }}" href="{{ route('admin') }}">Administração</a>
                        </li>
                    @endif
                </ul>

                <div class="header-actions order-lg-3">
                    <a href="{{ route('carrinho') }}" class="header-action {{ request()->routeIs('carrinho') || request()->routeIs('checkout') ? 'active' : '' }}" aria-label="Carrinho">
                        <span class="header-action__icon">
                            <i class="bi bi-bag"></i>
                            @if($cartCount > 0)
                                <span class="cart-count">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                            @endif
                        </span>
                        <span class="header-action__text">
                            <small>Carrinho</small>
                            <strong>{{ $cartCount }} {{ $cartCount === 1 ? 'item' : 'itens' }}</strong>
                        </span>
                    </a>

                    @if(session('cliente_nome'))
                        <div class="dropdown">
                            <button class="account-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="account-avatar">{{ mb_strtoupper(mb_substr(session('cliente_nome'), 0, 1)) }}</span>
                                <span class="account-copy">
                                    <small>Olá,</small>
                                    <strong>{{ \Illuminate\Support\Str::limit(session('cliente_nome'), 16) }}</strong>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end account-menu">
                                <li class="account-menu__header">
                                    <small>Conta conectada</small>
                                    <strong>{{ session('cliente_email') }}</strong>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(session('cliente_tipo') === 'cliente')
                                    <li><a class="dropdown-item" href="{{ route('biblioteca') }}"><i class="bi bi-collection-play"></i> Minha biblioteca</a></li>
                                @endif
                                @if(session('cliente_tipo') === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin') }}"><i class="bi bi-speedometer2"></i> Painel administrativo</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.produtos') }}"><i class="bi bi-box-seam"></i> Gerenciar produtos</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item dropdown-item--danger" type="submit"><i class="bi bi-box-arrow-right"></i> Sair</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="account-button {{ request()->routeIs('login') || request()->routeIs('cadastro') ? 'active' : '' }}">
                            <span class="header-action__icon"><i class="bi bi-person"></i></span>
                            <span class="account-copy">
                                <small>Bem-vindo</small>
                                <strong>Entrar ou cadastrar</strong>
                            </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>

@if(session('sucesso') || session('erro') || $errors->any())
    <div class="container flash-area">
        @if(session('sucesso'))
            <div class="alert alert-success app-alert alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('sucesso') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if(session('erro'))
            <div class="alert alert-danger app-alert alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>{{ session('erro') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger app-alert alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-octagon-fill"></i>
                <div>
                    <strong>Revise os campos informados:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif
    </div>
@endif

<div class="page-content">
    @yield('conteudo')
</div>

<footer class="site-footer">
    <div class="footer-benefits">
        <div class="container">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="footer-benefit"><i class="bi bi-lightning-charge"></i><div><strong>Acesso rápido</strong><span>Jogos digitais na sua conta</span></div></div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="footer-benefit"><i class="bi bi-shield-lock"></i><div><strong>Compra segura</strong><span>Seus dados sempre protegidos</span></div></div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="footer-benefit"><i class="bi bi-headset"></i><div><strong>Suporte</strong><span>Atendimento quando precisar</span></div></div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="footer-benefit"><i class="bi bi-controller"></i><div><strong>Feito para gamers</strong><span>Uma experiência simples e direta</span></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container footer-main">
        <div class="row g-4">
            <div class="col-lg-5">
                <a class="brand brand--footer" href="{{ route('home') }}">
                    <span class="brand__mark"><i class="bi bi-controller"></i></span>
                    <span class="brand__text">GAME<span>STORE</span></span>
                </a>
                <p class="footer-description">Uma vitrine moderna para descobrir, comprar e organizar seus jogos favoritos.</p>
            </div>
            <div class="col-6 col-lg-2">
                <h6>Navegação</h6>
                <a href="{{ route('home') }}">Loja</a>
                <a href="{{ route('carrinho') }}">Carrinho</a>
                @if(session('cliente_tipo') === 'cliente')<a href="{{ route('biblioteca') }}">Biblioteca</a>@endif
            </div>
            <div class="col-6 col-lg-2">
                <h6>Minha conta</h6>
                @if(session('cliente_nome'))
                    @if(session('cliente_tipo') === 'cliente')<a href="{{ route('biblioteca') }}">Minha biblioteca</a>@endif
                    @if(session('cliente_tipo') === 'admin')<a href="{{ route('admin') }}">Administração</a>@endif
                @else
                    <a href="{{ route('login') }}">Entrar</a>
                    <a href="{{ route('cadastro') }}">Criar conta</a>
                @endif
            </div>
            <div class="col-lg-3">
                <h6>Pagamento integrado</h6>
                <div class="payment-badges">
                    <span>CAÇAPAY</span><span>COMPRA DIGITAL</span>
                </div>
                <small class="footer-note">Ambiente demonstrativo para projeto acadêmico.</small>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} GameStore. Todos os direitos reservados.</span>
            <span>Design renovado para desktop e mobile.</span>
        </div>
    </div>
</footer>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/store.js') }}"></script>
@stack('scripts')
</body>
</html>
