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
        </div>
    </div>
</main>
@endsection
