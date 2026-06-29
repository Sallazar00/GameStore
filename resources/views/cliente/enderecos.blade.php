@extends('layouts.app', ['titulo' => 'Endereços'])

@section('conteudo')
<main class="container pb-5">
    <div class="box">
        <h1>Meus Endereços</h1>

        <form method="POST" action="{{ route('enderecos.salvar') }}">
            @csrf

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Descrição</label>
                    <input name="descricao" class="form-control" placeholder="Casa, trabalho..." required>
                </div>

                <div class="col-md-5 mb-3">
                    <label class="form-label">Logradouro</label>
                    <input name="logradouro" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Número</label>
                    <input name="numero" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Bairro</label>
                    <input name="bairro" class="form-control" required>
                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label">Cidade</label>
                    <select name="cidade_id" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach($cidades as $cidade)
                            <option value="{{ $cidade->id }}">{{ $cidade->nome }}/{{ $cidade->estado }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="btn btn-success">Salvar endereço</button>
        </form>
    </div>

    <div class="box">
        <h2>Endereços cadastrados</h2>

        @forelse($enderecos as $endereco)
            <div class="border rounded p-3 mb-2">
                <strong>{{ $endereco->descricao }}</strong><br>
                {{ $endereco->logradouro }}, {{ $endereco->numero }} —
                {{ $endereco->bairro }} —
                {{ $endereco->cidade->nome }}/{{ $endereco->cidade->estado }}

                <form method="POST" action="{{ route('enderecos.excluir', $endereco) }}" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Excluir</button>
                </form>
            </div>
        @empty
            <p>Nenhum endereço cadastrado.</p>
        @endforelse
    </div>
</main>
@endsection
