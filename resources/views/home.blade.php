<<<<<<< HEAD
@extends('layouts.app', ['titulo' => 'Loja de Jogos'])

@section('conteudo')
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="eyebrow">Sua próxima aventura começa aqui</span>
                <h1>Grandes jogos.<br><span>Uma nova experiência.</span></h1>
                <p>Encontre títulos para diferentes plataformas, monte sua biblioteca e acompanhe tudo em uma loja rápida, moderna e fácil de usar.</p>

                <div class="hero-actions">
                    <a href="#catalogo" class="btn btn-success btn-lg"><i class="bi bi-controller me-2"></i>Explorar catálogo</a>
                    @if(!session('cliente_nome'))
                        <a href="{{ route('cadastro') }}" class="btn btn-outline-light btn-lg"><i class="bi bi-person-plus me-2"></i>Criar minha conta</a>
                    @elseif(session('cliente_tipo') === 'cliente')
                        <a href="{{ route('biblioteca') }}" class="btn btn-outline-light btn-lg"><i class="bi bi-collection-play me-2"></i>Minha biblioteca</a>
                    @endif
                </div>

                <div class="hero-note">
                    <span><i class="bi bi-check-circle-fill"></i> Compra simples</span>
                    <span><i class="bi bi-check-circle-fill"></i> Biblioteca organizada</span>
                    <span><i class="bi bi-check-circle-fill"></i> Design responsivo</span>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="hero-art" aria-hidden="true">
                    <div class="hero-art__glow"></div>
                    <div class="hero-card hero-card--two">
                        <img src="{{ asset('images/league.jpg') }}" alt="">
                    </div>
                    <div class="hero-card hero-card--one">
                        <img src="{{ asset('images/silent.jpg') }}" alt="">
                        <span class="hero-card__label"><small>Destaque</small><strong>Novas aventuras</strong></span>
                    </div>
                    <div class="hero-card hero-card--three">
                        <img src="{{ asset('images/strike.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="trust-strip">
    <div class="container">
        <div class="row g-0">
            <div class="col-6 col-lg-3">
                <div class="trust-strip__item"><i class="bi bi-lightning-charge"></i><div><strong>Acesso rápido</strong><span>Compre e acesse sua biblioteca</span></div></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-strip__item"><i class="bi bi-shield-check"></i><div><strong>Ambiente seguro</strong><span>Navegação protegida</span></div></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-strip__item"><i class="bi bi-grid"></i><div><strong>Várias categorias</strong><span>Jogos para todos os estilos</span></div></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-strip__item"><i class="bi bi-phone"></i><div><strong>100% responsivo</strong><span>Use no computador ou celular</span></div></div>
            </div>
        </div>
    </div>
</section>

<main id="catalogo" class="section">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-kicker">Explore por estilo</span>
                <h2>Encontre o jogo ideal</h2>
                <p>Navegue por categoria ou use a busca para chegar mais rápido ao título que procura.</p>
            </div>
            @if(session('cliente_tipo') === 'admin')
                <a href="{{ route('admin.produtos') }}" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i>Novo produto</a>
            @endif
        </div>

        <div class="category-chips mb-4">
            <a href="{{ route('home') }}#catalogo" class="category-chip {{ !$categoriaId ? 'active' : '' }}"><i class="bi bi-grid-fill"></i>Todos</a>
            @foreach($categorias as $categoria)
                <a href="{{ route('home', ['categoria_id' => $categoria->id]) }}#catalogo" class="category-chip {{ (string) $categoriaId === (string) $categoria->id ? 'active' : '' }}">
                    <i class="bi bi-joystick"></i>{{ $categoria->nome }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('home') }}#catalogo" class="filter-panel">
            <div class="row g-2 align-items-center">
                <div class="col-lg-7">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted-custom"></i>
                        <input name="busca" value="{{ $busca }}" class="form-control ps-5" placeholder="Pesquisar por nome ou descrição...">
                    </div>
                </div>
                <div class="col-lg-3">
                    <select name="categoria_id" class="form-select">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" @selected($categoriaId == $categoria->id)>{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 d-grid">
                    <button class="btn btn-primary"><i class="bi bi-funnel me-2"></i>Filtrar</button>
                </div>
            </div>
        </form>

        <div class="section-heading">
            <div>
                <span class="section-kicker">Catálogo</span>
                <h2>{{ $busca || $categoriaId ? 'Resultados encontrados' : 'Jogos em destaque' }}</h2>
                <p>{{ $produtos->count() }} {{ $produtos->count() === 1 ? 'produto disponível' : 'produtos disponíveis' }}</p>
            </div>
            @if($busca || $categoriaId)
                <a href="{{ route('home') }}#catalogo" class="btn btn-ghost btn-sm"><i class="bi bi-x-lg me-1"></i>Limpar filtros</a>
            @endif
        </div>

        <div class="row product-grid">
            @forelse($produtos as $produto)
                @php
                    $foto = $produto->fotos->first();
                    $imagem = $foto
                        ? (str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo))
                        : asset('images/placeholder-game.svg');
                @endphp

                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <article class="product-card">
                        <a href="{{ route('produto.show', $produto->slug) }}" class="product-card__media">
                            <img src="{{ $imagem }}" data-fallback alt="Capa de {{ $produto->nome }}" loading="lazy">
                            <div class="product-card__badges">
                                <span class="product-badge product-badge--platform"><i class="bi bi-display"></i>{{ $produto->plataforma->nome ?? 'Multiplataforma' }}</span>
                                <span class="product-badge {{ $produto->quantidade_estoque > 0 ? 'product-badge--stock' : 'product-badge--out' }}">
                                    {{ $produto->quantidade_estoque > 0 ? 'Disponível' : 'Esgotado' }}
                                </span>
                            </div>
                        </a>

                        <div class="product-card__body">
                            <div class="product-card__category">{{ $produto->categoria->nome ?? 'Sem categoria' }}</div>
                            <h3 class="product-card__title"><a href="{{ route('produto.show', $produto->slug) }}">{{ $produto->nome }}</a></h3>
                            <p class="product-card__description">{{ $produto->descricao }}</p>

                            <div class="product-card__price-row">
                                <div class="product-card__price">
                                    <small>Preço</small>
                                    <strong>R$ {{ number_format($produto->valor, 2, ',', '.') }}</strong>
                                </div>
                                <span class="product-card__stock-text">{{ $produto->quantidade_estoque }} em estoque</span>
                            </div>

                            <div class="product-card__actions">
                                @if($produto->quantidade_estoque > 0)
                                    <form method="POST" action="{{ route('carrinho.adicionar', $produto) }}" class="d-grid">
                                        @csrf
                                        <input type="hidden" name="quantidade" value="1">
                                        <button class="btn btn-success btn-sm"><i class="bi bi-bag-plus"></i>Adicionar</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Esgotado</button>
                                @endif
                                <a href="{{ route('produto.show', $produto->slug) }}" class="btn btn-outline-light btn-sm" aria-label="Ver detalhes de {{ $produto->nome }}"><i class="bi bi-eye"></i></a>
                            </div>

                            @if(session('cliente_tipo') === 'admin')
                                <form method="POST" action="{{ route('admin.produtos.excluir', $produto) }}" class="mt-2 d-grid" onsubmit="return confirm('Excluir este produto da loja?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash3 me-1"></i>Excluir produto</button>
                                </form>
                            @endif
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <span class="empty-state__icon"><i class="bi bi-search"></i></span>
                        <h3>Nenhum jogo encontrado</h3>
                        <p>Tente alterar os filtros ou pesquisar usando outro nome. Caso seja administrador, você também pode cadastrar um novo produto.</p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('home') }}#catalogo" class="btn btn-primary">Ver todo o catálogo</a>
                            @if(session('cliente_tipo') === 'admin')
                                <a href="{{ route('admin.produtos') }}" class="btn btn-success">Cadastrar produto</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</main>

<section class="section section--surface">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-kicker">Por que escolher a GameStore?</span>
                <h2>Uma jornada mais simples do início ao fim</h2>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4"><div class="feature-card"><span class="feature-card__icon"><i class="bi bi-search-heart"></i></span><h3>Descoberta rápida</h3><p>Busca, filtros e categorias para encontrar jogos sem perder tempo.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><span class="feature-card__icon"><i class="bi bi-bag-check"></i></span><h3>Compra organizada</h3><p>Carrinho e checkout claros, com resumo completo antes de finalizar.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><span class="feature-card__icon"><i class="bi bi-collection-play"></i></span><h3>Biblioteca pessoal</h3><p>Todos os títulos comprados ficam reunidos em um só lugar.</p></div></div>
        </div>
    </div>
</section>
=======
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
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
@endsection
