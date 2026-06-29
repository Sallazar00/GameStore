<<<<<<< HEAD
@extends('layouts.app', ['titulo' => 'Minha Biblioteca'])

@section('conteudo')
<section class="page-hero">
    <div class="container">
        <div class="page-hero__inner">
            <div>
                <span class="section-kicker">Sua coleção digital</span>
                <h1>Minha biblioteca</h1>
                <p>Os jogos aprovados pelo CaçaPay ficam disponíveis aqui imediatamente.</p>
            </div>
            <a href="{{ route('home') }}#catalogo" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i>Adicionar jogos</a>
        </div>
    </div>
</section>

<main class="section section--compact pt-3">
    <div class="container">
        @forelse($vendas as $venda)
            @php
                $codigoPedido = $venda->codigo_pedido ?: 'PED-' . str_pad($venda->id, 6, '0', STR_PAD_LEFT);
                $pagamentoAprovado = strcasecmp((string) ($venda->cacapay_status ?: 'Aprovado'), 'Aprovado') === 0;
            @endphp

            <section class="library-order">
                <header class="library-order__header">
                    <div>
                        <strong>{{ $codigoPedido }}</strong>
                        <span>Registrado em {{ optional($venda->created_at)->format('d/m/Y \à\s H:i') ?? 'data não informada' }}</span>
                    </div>
                    <div class="text-md-end">
                        <strong>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</strong>
                        <span>{{ $venda->produtos->sum(fn ($produto) => $produto->pivot->quantidade) }} item(ns)</span>
                    </div>
                </header>

                <div class="library-order__body">
                    <div class="order-integration-status mb-4">
                        <div>
                            <span class="order-integration-status__icon"><i class="bi bi-credit-card"></i></span>
                            <div>
                                <small>Pagamento CaçaPay</small>
                                <strong class="{{ $pagamentoAprovado ? 'text-success' : 'text-warning' }}">{{ $venda->cacapay_status ?: 'Aprovado' }}</strong>
                                @if($venda->cacapay_transacao_id)
                                    <span>Transação #{{ $venda->cacapay_transacao_id }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <span class="order-integration-status__icon"><i class="bi bi-cloud-check"></i></span>
                            <div>
                                <small>Entrega</small>
                                <strong>Digital</strong>
                                <span>Disponível na biblioteca</span>
                            </div>
                        </div>
                    </div>

                    @if($venda->integracao_erro)
                        <div class="alert alert-warning app-alert mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div><strong>Atenção:</strong> {{ $venda->integracao_erro }}</div>
                        </div>
                    @endif

                    <div class="row g-3">
                        @foreach($venda->produtos as $produto)
                            @php
                                $foto = $produto->fotos->first();
                                $imagem = $foto
                                    ? (str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo))
                                    : asset('images/placeholder-game.svg');
                            @endphp
                            <div class="col-sm-6 col-lg-4">
                                <article class="library-game">
                                    <img src="{{ $imagem }}" data-fallback alt="{{ $produto->nome }}" loading="lazy">
                                    <div class="library-game__body">
                                        <span class="badge badge-success-soft mb-2"><i class="bi bi-check-circle me-1"></i>Na biblioteca</span>
                                        <h3>{{ $produto->nome }}</h3>
                                        <p>Quantidade adquirida: {{ $produto->pivot->quantidade }}</p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-primary btn-sm flex-grow-1" type="button"><i class="bi bi-play-fill me-1"></i>Jogar</button>
                                            <a href="{{ route('produto.show', $produto->slug) }}" class="btn btn-outline-light btn-sm"><i class="bi bi-info-circle"></i></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @empty
            <div class="empty-state">
                <span class="empty-state__icon"><i class="bi bi-collection-play"></i></span>
                <h3>Sua biblioteca ainda está vazia</h3>
                <p>Quando o CaçaPay aprovar uma compra, os jogos aparecerão automaticamente nesta página.</p>
                <a href="{{ route('home') }}#catalogo" class="btn btn-success"><i class="bi bi-controller me-2"></i>Explorar jogos</a>
            </div>
        @endforelse
    </div>
=======
@extends('layouts.app', ['titulo' => 'Biblioteca'])

@section('conteudo')
<main class="container pb-5">
    <div class="box mb-4">
        <h1>Minha Biblioteca</h1>
        <p>Jogos comprados pelo usuário cliente.</p>
    </div>

    @forelse($vendas as $venda)
        <div class="box mb-4">
            <h4>Venda #{{ $venda->id }} — R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</h4>
            <p class="mb-2">
                Entrega:
                {{ $venda->endereco->logradouro ?? '' }},
                {{ $venda->endereco->numero ?? '' }}
            </p>

            <div class="row">
                @foreach($venda->produtos as $produto)
                    @php
                        $foto = $produto->fotos->first();
                        $imagem = $foto
                            ? (str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo))
                            : 'https://placehold.co/600x400/2a475e/ffffff?text=GameStore';
                    @endphp

                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $imagem }}" class="card-img-top game-img" alt="{{ $produto->nome }}">
                            <div class="card-body">
                                <h5>{{ $produto->nome }}</h5>
                                <p>Quantidade comprada: {{ $produto->pivot->quantidade }}</p>
                                <button class="btn btn-primary btn-sm">Jogar</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="box">
            <p>Você ainda não comprou nenhum jogo.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Ir para a loja</a>
        </div>
    @endforelse
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
</main>
@endsection
