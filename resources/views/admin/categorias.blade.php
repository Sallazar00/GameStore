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
        </div>
    </div>
</main>
@endsection
