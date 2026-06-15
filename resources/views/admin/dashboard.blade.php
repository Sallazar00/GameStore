@extends('layouts.app', ['titulo' => 'Admin'])

@section('conteudo')
<main class="container pb-5">
    <div class="box">
        <h1>Painel Administrativo</h1>
        <p>Área disponível apenas para administradores.</p>

        <div class="row">
            <div class="col-md-3 mb-3"><div class="card p-3"><h3>{{ $produtos }}</h3><p>Produtos</p></div></div>
            <div class="col-md-3 mb-3"><div class="card p-3"><h3>{{ $categorias }}</h3><p>Categorias</p></div></div>
            <div class="col-md-3 mb-3"><div class="card p-3"><h3>{{ $cidades }}</h3><p>Cidades</p></div></div>
            <div class="col-md-3 mb-3"><div class="card p-3"><h3>{{ $plataformas }}</h3><p>Plataformas</p></div></div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.produtos') }}" class="btn btn-success">Cadastrar Produtos</a>
            <a href="{{ route('admin.categorias') }}" class="btn btn-primary">Categorias</a>
            <a href="{{ route('admin.plataformas') }}" class="btn btn-primary">Plataformas</a>
            <a href="{{ route('admin.cidades') }}" class="btn btn-primary">Cidades</a>
        </div>
    </div>
</main>
@endsection
