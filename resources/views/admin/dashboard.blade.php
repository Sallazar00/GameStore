@extends('layouts.app', ['titulo' => 'Painel Administrativo'])

@section('conteudo')
<section class="page-hero">
    <div class="container">
        <div class="page-hero__inner">
            <div>
                <span class="section-kicker">Central de gestão</span>
                <h1>Painel administrativo</h1>
                <p>Acompanhe os principais números e gerencie o catálogo digital da loja.</p>
            </div>
            <a href="{{ route('admin.produtos') }}" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i>Novo produto</a>
        </div>
    </div>
</section>

<main class="admin-layout pt-3">
    <div class="container">
        @include('admin._nav')

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <article class="admin-stat">
                    <div class="admin-stat__top"><span class="admin-stat__icon"><i class="bi bi-box-seam"></i></span><span class="badge badge-success-soft">Catálogo</span></div>
                    <strong>{{ $produtos }}</strong><span>Produtos cadastrados</span>
                </article>
            </div>
            <div class="col-md-4">
                <article class="admin-stat">
                    <div class="admin-stat__top"><span class="admin-stat__icon"><i class="bi bi-tags"></i></span><span class="badge badge-soft">Organização</span></div>
                    <strong>{{ $categorias }}</strong><span>Categorias ativas</span>
                </article>
            </div>
            <div class="col-md-4">
                <article class="admin-stat">
                    <div class="admin-stat__top"><span class="admin-stat__icon"><i class="bi bi-display"></i></span><span class="badge badge-soft">Sistemas</span></div>
                    <strong>{{ $plataformas }}</strong><span>Plataformas disponíveis</span>
                </article>
            </div>
        </div>

        <div class="content-panel">
            <div class="panel-title">
                <div><h2>Ações rápidas</h2><p>Escolha o módulo que deseja gerenciar.</p></div>
            </div>
            <div class="row g-3">
                <div class="col-md-4"><a href="{{ route('admin.produtos') }}" class="feature-card d-block"><span class="feature-card__icon"><i class="bi bi-box-seam"></i></span><h3>Produtos</h3><p>Cadastre jogos, estoque, preço e imagens.</p></a></div>
                <div class="col-md-4"><a href="{{ route('admin.categorias') }}" class="feature-card d-block"><span class="feature-card__icon"><i class="bi bi-tags"></i></span><h3>Categorias</h3><p>Organize os produtos por gênero.</p></a></div>
                <div class="col-md-4"><a href="{{ route('admin.plataformas') }}" class="feature-card d-block"><span class="feature-card__icon"><i class="bi bi-display"></i></span><h3>Plataformas</h3><p>Gerencie PC, Xbox, PlayStation e outras.</p></a></div>
            </div>
        </div>
    </div>
</main>
@endsection
