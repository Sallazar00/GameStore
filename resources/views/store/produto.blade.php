@extends('layouts.app', ['titulo' => $produto->nome])

@section('conteudo')
<<<<<<< HEAD
@php
    $fotoPrincipal = $produto->fotos->first();
    $imagemPrincipal = $fotoPrincipal
        ? (str_starts_with($fotoPrincipal->nome_arquivo, 'http') ? $fotoPrincipal->nome_arquivo : asset($fotoPrincipal->nome_arquivo))
        : asset('images/placeholder-game.svg');
@endphp

<main class="product-detail">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Loja</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home', ['categoria_id' => $produto->categoria_id]) }}">{{ $produto->categoria->nome ?? 'Jogos' }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $produto->nome }}</li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5">
            <div class="col-lg-5">
                <div class="product-gallery">
                    <img src="{{ $imagemPrincipal }}" data-main-product-image data-fallback class="product-main-image" alt="Capa de {{ $produto->nome }}">

                    @if($produto->fotos->count() > 1)
                        <div class="product-thumbs">
                            @foreach($produto->fotos as $index => $foto)
                                @php
                                    $url = str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo);
                                @endphp
                                <img src="{{ $url }}" data-product-thumb="{{ $url }}" data-fallback class="product-thumb {{ $index === 0 ? 'active' : '' }}" alt="Miniatura {{ $index + 1 }} de {{ $produto->nome }}">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-7">
                <div class="product-info">
                    <span class="eyebrow">{{ $produto->categoria->nome ?? 'Jogo digital' }}</span>
                    <h1>{{ $produto->nome }}</h1>
                    <p class="product-info__description">{{ $produto->descricao }}</p>

                    <div class="product-meta">
                        <span class="meta-pill"><i class="bi bi-display"></i>{{ $produto->plataforma->nome ?? 'Multiplataforma' }}</span>
                        <span class="meta-pill"><i class="bi bi-grid"></i>{{ $produto->categoria->nome ?? 'Sem categoria' }}</span>
                        <span class="meta-pill"><i class="bi bi-box-seam"></i>{{ $produto->quantidade_estoque }} em estoque</span>
                    </div>

                    <div class="product-price-box">
                        <small>Preço do jogo</small>
                        <strong>R$ {{ number_format($produto->valor, 2, ',', '.') }}</strong>
                    </div>

                    @if($produto->quantidade_estoque > 0)
                        <form method="POST" action="{{ route('carrinho.adicionar', $produto) }}">
                            @csrf
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <div class="buy-row">
                                <input id="quantidade" type="number" name="quantidade" class="form-control quantity-control" value="1" min="1" max="{{ $produto->quantidade_estoque }}">
                                <button class="btn btn-success btn-lg"><i class="bi bi-bag-plus me-2"></i>Adicionar ao carrinho</button>
                                <a href="{{ route('home') }}#catalogo" class="btn btn-outline-light btn-lg" aria-label="Voltar ao catálogo"><i class="bi bi-arrow-left"></i></a>
                            </div>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled><i class="bi bi-x-circle me-2"></i>Produto sem estoque</button>
                    @endif

                    <div class="product-assurances">
                        <div class="assurance"><i class="bi bi-lightning-charge"></i>Acesso rápido</div>
                        <div class="assurance"><i class="bi bi-shield-check"></i>Compra segura</div>
                        <div class="assurance"><i class="bi bi-headset"></i>Suporte ao cliente</div>
                    </div>

                    @if(session('cliente_tipo') === 'admin')
                        <div class="mt-4 pt-4 border-top border-secondary border-opacity-25">
                            <small class="text-muted-custom d-block mb-2">Ações administrativas</small>
                            <form method="POST" action="{{ route('admin.produtos.excluir', $produto) }}" onsubmit="return confirm('Excluir este produto da loja?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash3 me-1"></i>Excluir produto</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
=======
<main class="container pb-5">
    <div class="box">
        <div class="row">
            <div class="col-md-5">
                @php
                    $foto = $produto->fotos->first();
                    $imagem = $foto
                        ? (str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo))
                        : 'https://placehold.co/600x400/2a475e/ffffff?text=GameStore';
                @endphp
                <img src="{{ $imagem }}" class="img-fluid rounded" alt="{{ $produto->nome }}">
            </div>
            <div class="col-md-7">
                <h1>{{ $produto->nome }}</h1>
                <p>{{ $produto->descricao }}</p>
                <p><strong>Categoria:</strong> {{ $produto->categoria->nome ?? '-' }}</p>
                <p><strong>Plataforma:</strong> {{ $produto->plataforma->nome ?? '-' }}</p>
                <p><strong>Estoque:</strong> {{ $produto->quantidade_estoque }}</p>
                <h3>R$ {{ number_format($produto->valor, 2, ',', '.') }}</h3>

                <form method="POST" action="{{ route('carrinho.adicionar', $produto) }}" class="d-flex gap-2 flex-wrap mt-3">
                    @csrf
                    <input type="number" name="quantidade" class="form-control" value="1" min="1" max="{{ $produto->quantidade_estoque }}" style="max-width:120px">
                    <button class="btn btn-success">Adicionar ao carrinho</button>
                    <a href="{{ route('home') }}" class="btn btn-outline-light">Voltar</a>
                </form>
            </div>
        </div>

        @if($produto->fotos->count() > 1)
            <hr>
            <h4>Fotos do produto</h4>
            <div class="row">
                @foreach($produto->fotos as $foto)
                    @php
                        $url = str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo);
                    @endphp
                    <div class="col-md-3 mb-3">
                        <img src="{{ $url }}" class="img-fluid rounded" alt="Foto do produto">
                    </div>
                @endforeach
            </div>
        @endif
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
    </div>
</main>
@endsection
