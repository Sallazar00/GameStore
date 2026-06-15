<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo ?? 'GameStore' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#1b2838; color:white; }
        .navbar { background:#171a21; }
        .navbar .container { display:flex; align-items:center; }
        .nav-actions { margin-left:auto; display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; justify-content:flex-end; }
        .banner { padding:70px 20px; text-align:center; background:#1b2838; }
        .card { background:#2a475e; color:white; border:0; transition:.25s; height:100%; }
        .card:hover { transform:scale(1.02); }
        .game-img { width:100%; height:300px; object-fit:cover; background:#111827; }
        .box { background:#2a475e; padding:30px; border-radius:10px; margin-top:30px; }
        .form-control, .form-select { background:#f8f9fa; }
        a { text-decoration:none; }
        .dropdown-menu { background:#171a21; }
        .dropdown-item { color:white; }
        .dropdown-item:hover { background:#2a475e; color:white; }
        .badge-soft { background:#66c0f4; color:#111827; }
        .table-dark-custom { --bs-table-bg:#2a475e; --bs-table-color:white; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">🎮 GameStore</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGameStore">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarGameStore">
            <div class="nav-actions">
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">Home</a>
                <a href="{{ route('carrinho') }}" class="btn btn-outline-light btn-sm">Carrinho</a>

                @if(session('cliente_tipo') === 'cliente')
                    <a href="{{ route('biblioteca') }}" class="btn btn-outline-light btn-sm">Biblioteca</a>
                    <a href="{{ route('enderecos') }}" class="btn btn-outline-light btn-sm">Endereços</a>
                @endif

                @if(session('cliente_tipo') === 'admin')
                    <a href="{{ route('admin') }}" class="btn btn-outline-light btn-sm">Admin</a>
                    <a href="{{ route('admin.produtos') }}" class="btn btn-outline-light btn-sm">Produtos</a>
                @endif

                @if(session('cliente_nome'))
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Olá, {{ session('cliente_nome') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(session('cliente_tipo') === 'cliente')
                                <li><a class="dropdown-item" href="{{ route('biblioteca') }}">Minha biblioteca</a></li>
                                <li><a class="dropdown-item" href="{{ route('enderecos') }}">Meus endereços</a></li>
                            @endif

                            @if(session('cliente_tipo') === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin') }}">Painel admin</a></li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    <a href="{{ route('cadastro') }}" class="btn btn-success btn-sm">Cadastrar</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="container mt-3">
    @if(session('sucesso'))
        <div class="alert alert-success">{{ session('sucesso') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger">{{ session('erro') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Verifique os campos:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@yield('conteudo')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
