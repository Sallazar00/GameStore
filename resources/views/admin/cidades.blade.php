@extends('layouts.app', ['titulo' => 'Cidades'])

@section('conteudo')
<main class="container pb-5">
    <div class="box">
        <h1>Cadastro de Cidades de Atuação</h1>

        <form method="POST" action="{{ route('admin.cidades.salvar') }}">
            @csrf

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nome da cidade</label>
                    <input name="nome" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado</label>
                    <input name="estado" class="form-control" maxlength="2" placeholder="SC" required>
                </div>
            </div>

            <button class="btn btn-success">Salvar Cidade</button>
        </form>
    </div>

    <div class="box">
        <h2>Cidades cadastradas</h2>

        <div class="table-responsive">
            <table class="table table-dark-custom align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cidades as $cidade)
                        <tr>
                            <td>{{ $cidade->id }}</td>
                            <td>{{ $cidade->nome }}</td>
                            <td>{{ $cidade->estado }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.cidades.excluir', $cidade) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($cidades->count() === 0)
                        <tr><td colspan="4">Nenhuma cidade cadastrada.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
