<<<<<<< HEAD
@extends('layouts.app', ['titulo' => 'Gerenciar Categorias'])

@section('conteudo')
<section class="page-hero">
    <div class="container">
        <span class="section-kicker">Administração</span>
        <h1>Categorias</h1>
        <p>Crie gêneros e subcategorias para manter o catálogo organizado.</p>
    </div>
</section>

<main class="admin-layout pt-3">
    <div class="container">
        @include('admin._nav')
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="form-panel">
                    <div class="panel-title"><div><h2>Nova categoria</h2><p>Adicione uma opção ao catálogo.</p></div></div>
                    <form method="POST" action="{{ route('admin.categorias.salvar') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input id="nome" name="nome" class="form-control" value="{{ old('nome') }}" placeholder="Ex.: Aventura" required>
                        </div>
                        <div class="mb-4">
                            <label for="categoria_pai" class="form-label">Categoria pai</label>
                            <select id="categoria_pai" name="categoria_pai" class="form-select">
                                <option value="">Nenhuma (categoria principal)</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" @selected(old('categoria_pai') == $categoria->id)>{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Preencha apenas quando quiser criar uma subcategoria.</div>
                        </div>
                        <button class="btn btn-success w-100"><i class="bi bi-plus-lg me-2"></i>Salvar categoria</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-panel">
                    <div class="panel-title"><div><h2>Categorias cadastradas</h2><p>{{ $categorias->count() }} registro(s) encontrado(s).</p></div></div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead><tr><th>ID</th><th>Nome</th><th>Categoria pai</th><th class="text-end">Ações</th></tr></thead>
                            <tbody>
                                @forelse($categorias as $categoria)
                                    <tr>
                                        <td>#{{ $categoria->id }}</td>
                                        <td><strong>{{ $categoria->nome }}</strong></td>
                                        <td>{{ $categoria->pai->nome ?? 'Categoria principal' }}</td>
                                        <td class="text-end">
                                            <form method="POST" action="{{ route('admin.categorias.excluir', $categoria) }}" class="d-inline" onsubmit="return confirm('Excluir esta categoria?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted-custom">Nenhuma categoria cadastrada.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
=======
@extends('layouts.app', ['titulo' => 'Categorias'])

@section('conteudo')
<main class="container pb-5">
    <div class="box">
        <h1>Cadastro de Categorias</h1>

        <form method="POST" action="{{ route('admin.categorias.salvar') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome</label>
                    <input name="nome" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Categoria pai</label>
                    <select name="categoria_pai" class="form-select">
                        <option value="">Nenhuma</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="btn btn-success">Salvar Categoria</button>
        </form>
    </div>

    <div class="box">
        <h2>Categorias cadastradas</h2>

        <div class="table-responsive">
            <table class="table table-dark-custom align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Categoria pai</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->nome }}</td>
                            <td>{{ $categoria->pai->nome ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.categorias.excluir', $categoria) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($categorias->count() === 0)
                        <tr><td colspan="4">Nenhuma categoria cadastrada.</td></tr>
                    @endif
                </tbody>
            </table>
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
        </div>
    </div>
</main>
@endsection
