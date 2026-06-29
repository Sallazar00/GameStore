<<<<<<< HEAD
@extends('layouts.app', ['titulo' => 'Gerenciar Plataformas'])

@section('conteudo')
<section class="page-hero">
    <div class="container">
        <span class="section-kicker">Administração</span>
        <h1>Plataformas</h1>
        <p>Defina em quais sistemas os jogos do catálogo estão disponíveis.</p>
    </div>
</section>

<main class="admin-layout pt-3">
    <div class="container">
        @include('admin._nav')
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="form-panel">
                    <div class="panel-title"><div><h2>Nova plataforma</h2><p>Cadastre um novo sistema.</p></div></div>
                    <form method="POST" action="{{ route('admin.plataformas.salvar') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="nome" class="form-label">Nome da plataforma</label>
                            <input id="nome" name="nome" class="form-control" value="{{ old('nome') }}" placeholder="PC, PlayStation, Xbox..." required>
                        </div>
                        <button class="btn btn-success w-100"><i class="bi bi-plus-lg me-2"></i>Salvar plataforma</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-panel">
                    <div class="panel-title"><div><h2>Plataformas cadastradas</h2><p>{{ $plataformas->count() }} registro(s) encontrado(s).</p></div></div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead><tr><th>ID</th><th>Plataforma</th><th class="text-end">Ações</th></tr></thead>
                            <tbody>
                                @forelse($plataformas as $plataforma)
                                    <tr>
                                        <td>#{{ $plataforma->id }}</td>
                                        <td><span class="d-inline-flex align-items-center gap-2"><i class="bi bi-display text-muted-custom"></i><strong>{{ $plataforma->nome }}</strong></span></td>
                                        <td class="text-end">
                                            <form method="POST" action="{{ route('admin.plataformas.excluir', $plataforma) }}" class="d-inline" onsubmit="return confirm('Excluir esta plataforma?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center py-4 text-muted-custom">Nenhuma plataforma cadastrada.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
=======
@extends('layouts.app', ['titulo' => 'Plataformas'])

@section('conteudo')
<main class="container pb-5">
    <div class="box">
        <h1>Cadastro de Plataformas</h1>

        <form method="POST" action="{{ route('admin.plataformas.salvar') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nome da plataforma</label>
                <input name="nome" class="form-control" placeholder="PC, PlayStation, Xbox..." required>
            </div>

            <button class="btn btn-success">Salvar Plataforma</button>
        </form>
    </div>

    <div class="box">
        <h2>Plataformas cadastradas</h2>

        <div class="table-responsive">
            <table class="table table-dark-custom align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plataformas as $plataforma)
                        <tr>
                            <td>{{ $plataforma->id }}</td>
                            <td>{{ $plataforma->nome }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.plataformas.excluir', $plataforma) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($plataformas->count() === 0)
                        <tr><td colspan="3">Nenhuma plataforma cadastrada.</td></tr>
                    @endif
                </tbody>
            </table>
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
        </div>
    </div>
</main>
@endsection
