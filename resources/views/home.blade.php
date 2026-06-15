@extends('layouts.app', ['titulo' => 'GameStore'])

@section('conteudo')
<section class="banner">
    <h1>Bem-vindo à GameStore</h1>
    <p>Compre jogos digitais por categoria e plataforma.</p>
</section>

<main class="container pb-5">
    <form method="GET" action="{{ route('home') }}" class="box mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input name="busca" value="{{ $busca }}" class="form-control" placeholder="Pesquisar jogo...">
            </div>
            <div class="col-md-4">
                <select name="categoria_id" class="form-select">
                    <option value="">Todas as categorias</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected($categoriaId == $categoria->id)>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary">Pesquisar</button>
            </div>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2>Jogos em destaque</h2>

        @if(session('cliente_tipo') === 'admin')
            <a href="{{ route('admin.produtos') }}" class="btn btn-success">+ Cadastrar Produto</a>
        @endif
    </div>

    <div class="row">
        @forelse($produtos as $produto)
            @php
                $foto = $produto->fotos->first();
                $imagem = null;
                if ($foto) {
                    $imagem = str_starts_with($foto->nome_arquivo, 'http')
                        ? $foto->nome_arquivo
                        : asset($foto->nome_arquivo);
                } else {
                    $imagem = 'https://placehold.co/600x400/2a475e/ffffff?text=GameStore';
                }
            @endphp

            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $imagem }}" class="card-img-top game-img" alt="{{ $produto->nome }}">

                    <div class="card-body">
                        <h5>{{ $produto->nome }}</h5>
                        <p class="mb-1">{{ $produto->categoria->nome ?? 'Sem categoria' }}</p>
                        <p class="mb-1"><span class="badge badge-soft">{{ $produto->plataforma->nome ?? 'Sem plataforma' }}</span></p>
                        <p class="mb-1">Estoque: {{ $produto->quantidade_estoque }}</p>
                        <h5>R$ {{ number_format($produto->valor, 2, ',', '.') }}</h5>

                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('produto.show', $produto->slug) }}" class="btn btn-outline-light btn-sm">Detalhes</a>

                            @if($produto->quantidade_estoque > 0)
                                <form method="POST" action="{{ route('carrinho.adicionar', $produto) }}">
                                    @csrf
                                    <input type="hidden" name="quantidade" value="1">
                                    <button class="btn btn-success btn-sm">Adicionar ao carrinho</button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>Sem estoque</button>
                            @endif

                            @if(session('cliente_tipo') === 'admin')
                                <form method="POST" action="{{ route('admin.produtos.excluir', $produto) }}" onsubmit="return confirm('Excluir este produto da loja?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Excluir da loja</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="box">
                    <p class="mb-0">Nenhum produto cadastrado. Entre como admin e cadastre produtos em <strong>Admin &gt; Produtos</strong>.</p>
                </div>
            </div>
        @endforelse
    </div>
</main>
@endsection
