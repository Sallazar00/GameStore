@extends('layouts.app', ['titulo' => 'Gerenciar Produtos'])

@section('conteudo')
<section class="page-hero">
    <div class="container">
        <div class="page-hero__inner">
            <div>
                <span class="section-kicker">Administração</span>
                <h1>Produtos e jogos</h1>
                <p>Cadastre novos títulos, defina estoque, preço, categoria, plataforma e imagens.</p>
            </div>
            <span class="badge badge-soft">{{ $produtos->count() }} {{ $produtos->count() === 1 ? 'produto' : 'produtos' }}</span>
        </div>
    </div>
</section>

<main class="admin-layout pt-3">
    <div class="container">
        @include('admin._nav')

        <div class="form-panel mb-4">
            <div class="panel-title">
                <div><h2>Publicar novo produto</h2><p>O produto aparecerá automaticamente na página inicial da loja.</p></div>
                <span class="badge badge-success-soft"><i class="bi bi-images me-1"></i>Até 5 fotos</span>
            </div>

            @if($categorias->count() === 0 || $plataformas->count() === 0)
                <div class="alert alert-warning border-0">
                    Antes de cadastrar um produto, crie pelo menos uma categoria e uma plataforma.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.produtos.salvar') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label for="nome" class="form-label">Nome do produto</label>
                        <input id="nome" name="nome" class="form-control" value="{{ old('nome') }}" placeholder="Ex.: Cyber Adventure" required>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="quantidade_estoque" class="form-label">Estoque inicial</label>
                        <input id="quantidade_estoque" name="quantidade_estoque" type="number" min="0" class="form-control" value="{{ old('quantidade_estoque', 1) }}" required>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label for="valor" class="form-label">Preço</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input id="valor" name="valor" class="form-control" value="{{ old('valor') }}" placeholder="99,90" inputmode="decimal" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="categoria_id" class="form-label">Categoria</label>
                        <select id="categoria_id" name="categoria_id" class="form-select" required>
                            <option value="">Selecione uma categoria</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="plataforma_id" class="form-label">Plataforma</label>
                        <select id="plataforma_id" name="plataforma_id" class="form-select" required>
                            <option value="">Selecione uma plataforma</option>
                            @foreach($plataformas as $plataforma)
                                <option value="{{ $plataforma->id }}" @selected(old('plataforma_id') == $plataforma->id)>{{ $plataforma->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea id="descricao" name="descricao" class="form-control" rows="4" placeholder="Apresente o jogo, estilo e principais características..." required>{{ old('descricao') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="url_imagem" class="form-label">URL da imagem principal</label>
                        <input id="url_imagem" name="url_imagem" type="url" class="form-control" value="{{ old('url_imagem') }}" placeholder="https://site.com/capa.jpg">
                        <div class="form-text">Opcional. Use um endereço direto para uma imagem.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="fotos" class="form-label">Upload de fotos</label>
                        <input id="fotos" name="fotos[]" type="file" class="form-control" multiple accept="image/*">
                        <div class="form-text" data-file-count>Selecione até 5 arquivos de imagem.</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-success px-4" @disabled($categorias->count() === 0 || $plataformas->count() === 0)><i class="bi bi-cloud-arrow-up me-2"></i>Publicar produto</button>
                </div>
            </form>
        </div>

        <div class="content-panel">
            <div class="panel-title">
                <div><h2>Produtos publicados</h2><p>Visualize e remova itens do catálogo.</p></div>
                <a href="{{ route('home') }}#catalogo" class="btn btn-outline-light btn-sm"><i class="bi bi-eye me-1"></i>Ver catálogo</a>
            </div>

            <div class="row g-3">
                @forelse($produtos as $produto)
                    @php
                        $foto = $produto->fotos->first();
                        $imagem = $foto
                            ? (str_starts_with($foto->nome_arquivo, 'http') ? $foto->nome_arquivo : asset($foto->nome_arquivo))
                            : asset('images/placeholder-game.svg');
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <article class="admin-product">
                            <img src="{{ $imagem }}" data-fallback alt="{{ $produto->nome }}" loading="lazy">
                            <div class="admin-product__body">
                                <div class="d-flex justify-content-between gap-2 mb-2">
                                    <span class="badge badge-soft">{{ $produto->plataforma->nome ?? 'Sem plataforma' }}</span>
                                    <span class="badge {{ $produto->quantidade_estoque > 0 ? 'badge-success-soft' : 'badge-danger-soft' }}">{{ $produto->quantidade_estoque }} em estoque</span>
                                </div>
                                <h3>{{ $produto->nome }}</h3>
                                <div class="admin-product__meta">
                                    {{ $produto->categoria->nome ?? 'Sem categoria' }} · {{ $produto->fotos->count() }}/5 foto(s)<br>
                                    Slug: <code>{{ $produto->slug }}</code>
                                </div>
                                <div class="admin-product__footer">
                                    <strong>R$ {{ number_format($produto->valor, 2, ',', '.') }}</strong>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('produto.show', $produto->slug) }}" class="btn btn-outline-light btn-sm"><i class="bi bi-eye"></i></a>
                                        <form method="POST" action="{{ route('admin.produtos.excluir', $produto) }}" onsubmit="return confirm('Excluir este produto e suas imagens?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state py-5">
                            <span class="empty-state__icon"><i class="bi bi-box-seam"></i></span>
                            <h3>Nenhum produto publicado</h3>
                            <p>Use o formulário acima para adicionar o primeiro jogo ao catálogo.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection
