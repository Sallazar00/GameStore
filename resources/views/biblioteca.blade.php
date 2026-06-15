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
</main>
@endsection
