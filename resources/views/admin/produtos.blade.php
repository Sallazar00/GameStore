@extends('layouts.app', ['titulo' => 'Produtos'])

@section('conteudo')
<main class="container pb-5">
    <div class="box">
        <h1>Cadastro de Produtos / Jogos</h1>
        <p>Cada produto pode estar relacionado a apenas uma categoria e uma plataforma. O sistema limita no máximo 5 fotos por produto.</p>

        <form method="POST" action="{{ route('admin.produtos.salvar') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome do produto</label>
                    <input name="nome" class="form-control" value="{{ old('nome') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Estoque inicial</label>
                    <input name="quantidade_estoque" type="number" min="0" class="form-control" value="{{ old('quantidade_estoque', 1) }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Valor</label>
                    <input name="valor" class="form-control" value="{{ old('valor') }}" placeholder="99.90" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Categoria</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Plataforma</label>
                    <select name="plataforma_id" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach($plataformas as $plataforma)
                            <option value="{{ $plataforma->id }}" @selected(old('plataforma_id') == $plataforma->id)>{{ $plataforma->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="4" required>{{ old('descricao') }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">URL da imagem principal (opcional)</label>
                    <input name="url_imagem" class="form-control" value="{{ old('url_imagem') }}" placeholder="https://site.com/imagem.jpg">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Upload de fotos (máximo 5)</label>
                    <input name="fotos[]" type="file" class="form-control" multiple accept="image/*">
                </div>
            </div>

            <button class="btn btn-success">Publicar Produto</button>
        </form>
    </div>

    <div class="box">
        <h2>Produtos cadastrados</h2>

        <div class="row">
            @forelse($produtos as $produto)
                @php
                    $foto = $produto->fotos->first();
                    $imagem = $foto
                        ? (str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo))
                        : 'https://placehold.co/600x400/2a475e/ffffff?text=GameStore';
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $imagem }}" class="card-img-top game-img" alt="{{ $produto->nome }}">

                        <div class="card-body">
                            <h5>{{ $produto->nome }}</h5>
                            <p>{{ $produto->categoria->nome ?? '-' }} / {{ $produto->plataforma->nome ?? '-' }}</p>
                            <p>Slug: <code>{{ $produto->slug }}</code></p>
                            <p>Estoque: {{ $produto->quantidade_estoque }}</p>
                            <p>Fotos: {{ $produto->fotos->count() }}/5</p>

                            <form method="POST" action="{{ route('admin.produtos.excluir', $produto) }}" onsubmit="return confirm('Excluir este produto?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Excluir da loja</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>Nenhum produto cadastrado.</p>
            @endforelse
        </div>
    </div>
</main>
@endsection
