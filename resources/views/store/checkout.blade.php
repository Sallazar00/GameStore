@extends('layouts.app', ['titulo' => 'Finalizar Compra'])

@section('conteudo')
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
