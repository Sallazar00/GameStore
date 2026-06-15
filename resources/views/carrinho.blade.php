@extends('layouts.app', ['titulo' => 'Carrinho'])

@section('conteudo')
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
            </div>
        @endif
    </div>
</main>
@endsection
