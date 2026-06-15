<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cidade;
use App\Models\Endereco;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    private function clienteLogado()
    {
        return session('cliente_tipo') === 'cliente';
    }

    public function index(Request $request)
    {
        $busca = $request->get('busca');
        $categoriaId = $request->get('categoria_id');

        $produtos = Produto::with(['categoria', 'plataforma', 'fotos'])
            ->when($busca, function ($query) use ($busca) {
                $query->where('nome', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
            })
            ->when($categoriaId, function ($query) use ($categoriaId) {
                $query->where('categoria_id', $categoriaId);
            })
            ->latest()
            ->get();

        $categorias = Categoria::orderBy('nome')->get();

        return view('home', compact('produtos', 'categorias', 'busca', 'categoriaId'));
    }

    public function produto($slug)
    {
        $produto = Produto::with(['categoria', 'plataforma', 'fotos'])->where('slug', $slug)->firstOrFail();
        return view('store.produto', compact('produto'));
    }

    public function carrinho()
    {
        $itens = $this->itensCarrinho();
        $total = collect($itens)->sum('subtotal');
        return view('carrinho', compact('itens', 'total'));
    }

    public function adicionarCarrinho(Request $request, Produto $produto)
    {
        $quantidade = max(1, (int) $request->get('quantidade', 1));

        if ($produto->quantidade_estoque < $quantidade) {
            return back()->with('erro', 'Quantidade indisponível em estoque.');
        }

        $carrinho = session('carrinho', []);

        if (isset($carrinho[$produto->id])) {
            $novaQtd = $carrinho[$produto->id]['quantidade'] + $quantidade;
        } else {
            $novaQtd = $quantidade;
        }

        if ($novaQtd > $produto->quantidade_estoque) {
            return back()->with('erro', 'Não há estoque suficiente para essa quantidade.');
        }

        $carrinho[$produto->id] = [
            'produto_id' => $produto->id,
            'quantidade' => $novaQtd,
        ];

        session(['carrinho' => $carrinho]);

        return redirect('/carrinho')->with('sucesso', 'Produto adicionado ao carrinho.');
    }

    public function removerCarrinho($produtoId)
    {
        $carrinho = session('carrinho', []);
        unset($carrinho[$produtoId]);
        session(['carrinho' => $carrinho]);

        return back()->with('sucesso', 'Produto removido do carrinho.');
    }

    public function limparCarrinho()
    {
        session()->forget('carrinho');
        return back()->with('sucesso', 'Carrinho limpo.');
    }

    public function checkout()
    {
        if (!$this->clienteLogado()) {
            return redirect('/login')->with('erro', 'Faça login como cliente para fechar a compra.');
        }

        $itens = $this->itensCarrinho();
        if (count($itens) === 0) {
            return redirect('/carrinho')->with('erro', 'Seu carrinho está vazio.');
        }

        $enderecos = Endereco::with('cidade')
            ->where('cliente_id', session('cliente_id'))
            ->get();

        $total = collect($itens)->sum('subtotal');

        return view('store.checkout', compact('itens', 'total', 'enderecos'));
    }

    public function finalizarCompra(Request $request)
    {
        if (!$this->clienteLogado()) {
            return redirect('/login')->with('erro', 'Faça login como cliente para fechar a compra.');
        }

        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
        ]);

        $endereco = Endereco::where('id', $request->endereco_id)
            ->where('cliente_id', session('cliente_id'))
            ->firstOrFail();

        $itens = $this->itensCarrinho();

        if (count($itens) === 0) {
            return redirect('/carrinho')->with('erro', 'Seu carrinho está vazio.');
        }

        foreach ($itens as $item) {
            if ($item['produto']->quantidade_estoque < $item['quantidade']) {
                return redirect('/carrinho')->with('erro', 'O produto "' . $item['produto']->nome . '" não possui estoque suficiente.');
            }
        }

        DB::transaction(function () use ($itens, $endereco) {
            $total = collect($itens)->sum('subtotal');

            $venda = Venda::create([
                'cliente_id' => session('cliente_id'),
                'endereco_id' => $endereco->id,
                'valor_total' => $total,
            ]);

            foreach ($itens as $item) {
                $produto = $item['produto'];

                $venda->produtos()->attach($produto->id, [
                    'quantidade' => $item['quantidade'],
                    'subtotal' => $item['subtotal'],
                ]);

                $produto->decrement('quantidade_estoque', $item['quantidade']);
            }
        });

        session()->forget('carrinho');

        return redirect('/biblioteca')->with('sucesso', 'Compra finalizada! Os jogos aparecerão na sua biblioteca.');
    }

    public function biblioteca()
    {
        if (!$this->clienteLogado()) {
            return redirect('/login')->with('erro', 'Faça login como cliente para acessar sua biblioteca.');
        }

        $vendas = Venda::with(['produtos.fotos', 'endereco.cidade'])
            ->where('cliente_id', session('cliente_id'))
            ->latest()
            ->get();

        return view('biblioteca', compact('vendas'));
    }

    private function itensCarrinho(): array
    {
        $carrinho = session('carrinho', []);
        $ids = array_keys($carrinho);

        if (count($ids) === 0) {
            return [];
        }

        $produtos = Produto::with('fotos')->whereIn('id', $ids)->get()->keyBy('id');

        $itens = [];

        foreach ($carrinho as $produtoId => $item) {
            if (!$produtos->has($produtoId)) {
                continue;
            }

            $produto = $produtos[$produtoId];
            $quantidade = (int) $item['quantidade'];

            $itens[] = [
                'produto' => $produto,
                'quantidade' => $quantidade,
                'subtotal' => $produto->valor * $quantidade,
            ];
        }

        return $itens;
    }
}
