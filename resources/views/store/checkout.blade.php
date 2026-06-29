@extends('layouts.app', ['titulo' => 'Finalizar Compra'])

@section('conteudo')
<<<<<<< HEAD
<section class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Loja</a></li>
                <li class="breadcrumb-item"><a href="{{ route('carrinho') }}">Carrinho</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <span class="section-kicker">Pagamento digital integrado</span>
        <h1>Finalizar compra</h1>
        <p>O valor será consultado no CaçaPay usando o CPF cadastrado na sua conta.</p>
    </div>
</section>

<main class="section section--compact pt-3">
    <div class="container">
        <div class="integration-flow mb-4" aria-label="Fluxo do pagamento">
            <div class="integration-step is-active">
                <span>1</span>
                <div><strong>Revisão</strong><small>Jogos e total</small></div>
            </div>
            <i class="bi bi-arrow-right"></i>
            <div class="integration-step">
                <span>2</span>
                <div><strong>CaçaPay</strong><small>Consulta pelo CPF</small></div>
            </div>
            <i class="bi bi-arrow-right"></i>
            <div class="integration-step">
                <span>3</span>
                <div><strong>Biblioteca</strong><small>Liberação digital</small></div>
            </div>
        </div>

        <form method="POST" action="{{ route('checkout.finalizar') }}" id="checkout-form">
            @csrf
            <input type="hidden" name="checkout_token" value="{{ $checkoutToken }}">

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="content-panel">
                        <div class="panel-title">
                            <div>
                                <h2>Itens do pedido</h2>
                                <p>{{ collect($itens)->sum('quantidade') }} {{ collect($itens)->sum('quantidade') === 1 ? 'item selecionado' : 'itens selecionados' }}</p>
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
                                <img src="{{ $imagem }}" data-fallback class="cart-item__image" alt="{{ $item['produto']->nome }}">
                                <div class="cart-item__info">
                                    <h3>{{ $item['produto']->nome }}</h3>
                                    <div class="cart-item__meta">
                                        <span>Quantidade: {{ $item['quantidade'] }}</span>
                                        <span>R$ {{ number_format($item['produto']->valor, 2, ',', '.') }} cada</span>
                                    </div>
                                </div>
                                <div class="cart-item__price">
                                    <small>Subtotal</small>
                                    <strong>R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</strong>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="form-panel mt-4">
                        <div class="panel-title">
                            <div>
                                <h2>Dados enviados ao CaçaPay</h2>
                                <p>A cobrança utiliza os dados já cadastrados na conta. Nenhum endereço é necessário.</p>
                            </div>
                            <span class="badge badge-success-soft"><i class="bi bi-shield-check me-1"></i>Conexão segura</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label">Cliente</label>
                                <div class="checkout-data"><i class="bi bi-person"></i><span>{{ $cliente->nome }}</span></div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CPF</label>
                                <div class="checkout-data"><i class="bi bi-person-vcard"></i><span>{{ $cliente->cpf }}</span></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Valor</label>
                                <div class="checkout-data"><i class="bi bi-currency-dollar"></i><span>R$ {{ number_format($total, 2, ',', '.') }}</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="content-panel mt-4">
                        <div class="panel-title">
                            <div>
                                <h2>Como o processamento funciona</h2>
                                <p>Fluxo simplificado para uma loja exclusivamente digital.</p>
                            </div>
                        </div>
                        <div class="integration-explanation">
                            <div><i class="bi bi-person-vcard"></i><span>O CPF, nome, e-mail e valor da compra são enviados ao CaçaPay.</span></div>
                            <div><i class="bi bi-x-circle"></i><span>Se o pagamento for negado, o pedido não é finalizado, o estoque não muda e o carrinho permanece intacto.</span></div>
                            <div><i class="bi bi-check-circle"></i><span>Se aprovado, a compra é finalizada e os jogos aparecem imediatamente na biblioteca.</span></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="summary-card">
                        <div class="panel-title">
                            <div><h2>Resumo final</h2><p>Confira antes de confirmar.</p></div>
                        </div>
                        <div class="summary-line"><span>Jogos digitais</span><strong>R$ {{ number_format($total, 2, ',', '.') }}</strong></div>
                        <div class="summary-line"><span>Entrega</span><strong>Digital e imediata</strong></div>
                        <div class="summary-line summary-line--total"><span>Total no CaçaPay</span><strong>R$ {{ number_format($total, 2, ',', '.') }}</strong></div>

                        <button class="btn btn-success w-100 mt-3" id="checkout-submit" type="submit">
                            <i class="bi bi-shield-check me-2"></i><span>Pagar e finalizar compra</span>
                        </button>
                        <a href="{{ route('carrinho') }}" class="btn btn-outline-light w-100 mt-2">Voltar ao carrinho</a>

                        <div class="security-note">
                            <i class="bi bi-lock"></i>
                            <span>O botão é bloqueado após o clique para reduzir o risco de cobranças duplicadas.</span>
                        </div>
                    </aside>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@push('scripts')
<script>
    (() => {
        const form = document.getElementById('checkout-form');
        const button = document.getElementById('checkout-submit');

        if (!form || !button) return;

        form.addEventListener('submit', () => {
            button.disabled = true;
            button.querySelector('i').className = 'spinner-border spinner-border-sm me-2';
            button.querySelector('span').textContent = 'Processando no CaçaPay...';
        });
    })();
</script>
@endpush
=======
<main class="container pb-5">
    <div class="box">
        <h1>Finalizar Compra</h1>

        @if($enderecos->count() === 0)
            <div class="alert alert-warning">
                Você precisa cadastrar um endereço antes de finalizar a compra.
            </div>
            <a href="{{ route('enderecos') }}" class="btn btn-success">Cadastrar endereço</a>
        @else
            <h4>Resumo</h4>

            <ul>
                @foreach($itens as $item)
                    <li>
                        {{ $item['produto']->nome }} —
                        {{ $item['quantidade'] }} unidade(s) —
                        R$ {{ number_format($item['subtotal'], 2, ',', '.') }}
                    </li>
                @endforeach
            </ul>

            <h3>Total: R$ {{ number_format($total, 2, ',', '.') }}</h3>

            <form method="POST" action="{{ route('checkout.finalizar') }}" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Endereço de entrega</label>
                    <select name="endereco_id" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach($enderecos as $endereco)
                            <option value="{{ $endereco->id }}">
                                {{ $endereco->descricao }} —
                                {{ $endereco->logradouro }}, {{ $endereco->numero }},
                                {{ $endereco->bairro }},
                                {{ $endereco->cidade->nome }}/{{ $endereco->cidade->estado }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">Confirmar compra</button>
                <a href="{{ route('carrinho') }}" class="btn btn-outline-light">Voltar ao carrinho</a>
            </form>
        @endif
    </div>
</main>
@endsection
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
