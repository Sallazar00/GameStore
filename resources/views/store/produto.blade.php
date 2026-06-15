@extends('layouts.app', ['titulo' => $produto->nome])

@section('conteudo')
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
    </div>
</main>
@endsection
