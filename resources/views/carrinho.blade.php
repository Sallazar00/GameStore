@extends('layouts.app', ['titulo' => 'Carrinho'])

@section('conteudo')
<<<<<<< HEAD
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Loja</a></li>
                <li class="breadcrumb-item active" aria-current="page">Carrinho</li>
            </ol>
        </nav>
        <div class="page-hero__inner">
            <div>
                <span class="section-kicker">Sua seleção</span>
                <h1>Carrinho de compras</h1>
                <p>Revise os jogos escolhidos antes de seguir para a finalização.</p>
            </div>
            @if(count($itens) > 0)
                <span class="badge badge-soft">{{ collect($itens)->sum('quantidade') }} {{ collect($itens)->sum('quantidade') === 1 ? 'item' : 'itens' }}</span>
            @endif
        </div>
    </div>
</section>

<main class="section section--compact pt-3">
    <div class="container">
        @if(count($itens) === 0)
            <div class="empty-state">
                <span class="empty-state__icon"><i class="bi bi-bag-x"></i></span>
                <h3>Seu carrinho está vazio</h3>
                <p>Explore o catálogo e adicione alguns jogos para continuar sua compra.</p>
                <a href="{{ route('home') }}#catalogo" class="btn btn-success"><i class="bi bi-controller me-2"></i>Ver jogos</a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="content-panel">
                        <div class="panel-title">
                            <div>
                                <h2>Produtos selecionados</h2>
                                <p>Confira quantidades e valores.</p>
                            </div>
                        </div>

                        @foreach($itens as $item)
                            @php
                                $foto = $item['produto']->fotos->first();
                                $imagem = $foto
                                    ? (str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo))
                                    : asset('images/placeholder-game.svg');
                            @endphp
                            <article class="cart-item">
                                <a href="{{ route('produto.show', $item['produto']->slug) }}">
                                    <img src="{{ $imagem }}" data-fallback class="cart-item__image" alt="{{ $item['produto']->nome }}">
                                </a>
                                <div class="cart-item__info">
                                    <h3><a href="{{ route('produto.show', $item['produto']->slug) }}">{{ $item['produto']->nome }}</a></h3>
                                    <div class="cart-item__meta">
                                        <span><i class="bi bi-box-seam me-1"></i>Quantidade: {{ $item['quantidade'] }}</span>
                                        <span><i class="bi bi-tag me-1"></i>Unitário: R$ {{ number_format($item['produto']->valor, 2, ',', '.') }}</span>
                                    </div>
                                    <form method="POST" action="{{ route('carrinho.remover', $item['produto']->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="cart-item__remove"><i class="bi bi-trash3 me-1"></i>Remover do carrinho</button>
                                    </form>
                                </div>
                                <div class="cart-item__price">
                                    <small>Subtotal</small>
                                    <strong>R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</strong>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between gap-2 flex-wrap mt-3">
                        <a href="{{ route('home') }}#catalogo" class="btn btn-outline-light"><i class="bi bi-arrow-left me-2"></i>Continuar comprando</a>
                        <form method="POST" action="{{ route('carrinho.limpar') }}" onsubmit="return confirm('Remover todos os produtos do carrinho?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-ghost"><i class="bi bi-trash3 me-2"></i>Limpar carrinho</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="summary-card">
                        <div class="panel-title">
                            <div><h2>Resumo da compra</h2><p>Valores antes da confirmação.</p></div>
                        </div>
                        <div class="summary-line"><span>Produtos</span><strong>R$ {{ number_format($total, 2, ',', '.') }}</strong></div>
                        <div class="summary-line"><span>Entrega digital</span><strong>Grátis</strong></div>
                        <div class="summary-line summary-line--total"><span>Total</span><strong>R$ {{ number_format($total, 2, ',', '.') }}</strong></div>
                        <a href="{{ route('checkout') }}" class="btn btn-success w-100 mt-3"><i class="bi bi-lock me-2"></i>Ir para o checkout</a>
                        <div class="security-note"><i class="bi bi-shield-check"></i><span>Você poderá revisar os jogos e o valor antes do pagamento no CaçaPay.</span></div>
                    </aside>
                </div>
=======
<main class="container pb-5">
    <div class="box">
        <h1>Carrinho</h1>

        @if(count($itens) === 0)
            <p>Seu carrinho está vazio.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Ver jogos</a>
        @else
            <div class="table-responsive">
                <table class="table table-dark-custom align-middle">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itens as $item)
                            <tr>
                                <td>{{ $item['produto']->nome }}</td>
                                <td>R$ {{ number_format($item['produto']->valor, 2, ',', '.') }}</td>
                                <td>{{ $item['quantidade'] }}</td>
                                <td>R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('carrinho.remover', $item['produto']->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3>Total: R$ {{ number_format($total, 2, ',', '.') }}</h3>

            <div class="d-flex gap-2 flex-wrap mt-3">
                <a href="{{ route('checkout') }}" class="btn btn-success">Fechar compra</a>

                <form method="POST" action="{{ route('carrinho.limpar') }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Limpar carrinho</button>
                </form>

                <a href="{{ route('home') }}" class="btn btn-outline-light">Continuar comprando</a>
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
            </div>
        @endif
    </div>
</main>
@endsection
