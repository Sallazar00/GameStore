<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    private function somenteCliente()
    {
        if (session('cliente_tipo') !== 'cliente') {
            abort(403, 'Acesso permitido apenas para clientes.');
        }
    }

    public function index()
    {
        $this->somenteCliente();

        return view('cliente.enderecos', [
            'enderecos' => Endereco::with('cidade')
                ->where('cliente_id', session('cliente_id'))
                ->get(),
            'cidades' => Cidade::orderBy('estado')->orderBy('nome')->get(),
        ]);
    }

    public function salvar(Request $request)
    {
        $this->somenteCliente();

        $dados = $request->validate([
            'descricao' => 'required|string|max:255',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'bairro' => 'required|string|max:255',
            'cidade_id' => 'required|exists:cidades,id',
        ]);

        $dados['cliente_id'] = session('cliente_id');

        Endereco::create($dados);

        return back()->with('sucesso', 'Endereço cadastrado.');
    }

    public function excluir(Endereco $endereco)
    {
        $this->somenteCliente();

        if ($endereco->cliente_id !== session('cliente_id')) {
            abort(403);
        }

        if ($endereco->vendas()->exists()) {
            return back()->with('erro', 'Não é possível excluir um endereço usado em venda.');
        }

        $endereco->delete();

        return back()->with('sucesso', 'Endereço excluído.');
    }
}
