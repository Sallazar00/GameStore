<?php

namespace App\Http\Controllers;

use App\Exceptions\CacaPayException;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Venda;
use App\Services\CacaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class StoreController extends Controller
{
    public function __construct(
        private readonly CacaPayService $cacaPay,
    ) {
    }

    private function clienteLogado(): bool
    {
        return session('cliente_tipo') === 'cliente';
    }

    public function index(Request $request)
    {
        $busca = $request->get('busca');
        $categoriaId = $request->get('categoria_id');

        $produtos = Produto::with(['categoria', 'plataforma', 'fotos'])
            ->when($busca, function ($query) use ($busca) {
                $query->where(function ($searchQuery) use ($busca) {
                    $searchQuery->where('nome', 'like', "%{$busca}%")
                        ->orWhere('descricao', 'like', "%{$busca}%");
                });
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
        $produto = Produto::with(['categoria', 'plataforma', 'fotos'])
            ->where('slug', $slug)
            ->firstOrFail();

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
        $novaQtd = isset($carrinho[$produto->id])
            ? $carrinho[$produto->id]['quantidade'] + $quantidade
            : $quantidade;

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
        session()->forget(['carrinho', 'checkout_token']);

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

        $cliente = Cliente::findOrFail(session('cliente_id'));
        $total = collect($itens)->sum('subtotal');
        $checkoutToken = (string) Str::uuid();

        session(['checkout_token' => $checkoutToken]);

        return view('store.checkout', compact('itens', 'total', 'cliente', 'checkoutToken'));
    }

    public function finalizarCompra(Request $request)
    {
        if (!$this->clienteLogado()) {
            return redirect('/login')->with('erro', 'Faça login como cliente para fechar a compra.');
        }

        $request->validate([
            'checkout_token' => ['required', 'string'],
        ]);

        $sessionToken = (string) session('checkout_token', '');
        session()->forget('checkout_token');

        if ($sessionToken === '' || !hash_equals($sessionToken, (string) $request->checkout_token)) {
            return redirect('/checkout')
                ->with('erro', 'Esta tentativa de compra expirou ou já foi processada. Revise o pedido e tente novamente.');
        }

        $cliente = Cliente::findOrFail(session('cliente_id'));
        $itens = $this->itensCarrinho();

        if (count($itens) === 0) {
            return redirect('/carrinho')->with('erro', 'Seu carrinho está vazio.');
        }

        foreach ($itens as $item) {
            if ($item['produto']->quantidade_estoque < $item['quantidade']) {
                return redirect('/carrinho')
                    ->with('erro', 'O produto "' . $item['produto']->nome . '" não possui estoque suficiente.');
            }
        }

        $total = (float) collect($itens)->sum('subtotal');

        // A tentativa é registrada antes da chamada externa. Assim, aprovações,
        // recusas e falhas de comunicação ficam auditáveis no banco local.
        $venda = DB::transaction(function () use ($cliente, $itens, $total) {
            $venda = Venda::create([
                'cliente_id' => $cliente->id,
                'valor_total' => $total,
                'status' => 'aguardando_pagamento',
            ]);

            $venda->update([
                'codigo_pedido' => 'PED-' . str_pad((string) $venda->id, 6, '0', STR_PAD_LEFT),
            ]);

            foreach ($itens as $item) {
                $venda->produtos()->attach($item['produto']->id, [
                    'quantidade' => $item['quantidade'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return $venda->fresh();
        });

        try {
            $pagamento = $this->cacaPay->cobrar($cliente, $total);
        } catch (CacaPayException $exception) {
            $venda->update([
                'status' => $exception->httpStatus === 422 ? 'pagamento_negado' : 'pagamento_nao_processado',
                'cacapay_status' => $exception->httpStatus === 422 ? 'Negado' : 'Falha de comunicação',
                'cacapay_resposta' => $exception->responseData ?: null,
                'integracao_erro' => $exception->getMessage(),
            ]);

            Log::warning('Compra não aprovada pelo CaçaPay.', [
                'venda_id' => $venda->id,
                'http_status' => $exception->httpStatus,
                'mensagem' => $exception->getMessage(),
            ]);

            // Conforme o fluxograma: se o CaçaPay negar, a compra não é
            // finalizada, o estoque não muda e o carrinho permanece intacto.
            return redirect('/checkout')
                ->with('erro', 'Compra não finalizada: ' . $exception->getMessage());
        }

        $venda->update([
            'status' => 'pagamento_aprovado',
            'cacapay_transacao_id' => (string) data_get($pagamento, 'id', ''),
            'cacapay_status' => (string) data_get($pagamento, 'status.nome', 'Aprovado'),
            'cacapay_resposta' => $pagamento,
            'pago_em' => now(),
            'integracao_erro' => null,
        ]);

        try {
            DB::transaction(function () use ($itens, $venda) {
                foreach ($itens as $item) {
                    $produto = Produto::whereKey($item['produto']->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    if ($produto->quantidade_estoque < $item['quantidade']) {
                        throw new \RuntimeException('Estoque alterado durante o processamento do pagamento.');
                    }

                    $produto->decrement('quantidade_estoque', $item['quantidade']);
                }

                $venda->update(['status' => 'pago']);
            });
        } catch (Throwable $exception) {
            $venda->update([
                'status' => 'revisao_manual',
                'integracao_erro' => $exception->getMessage(),
            ]);

            session()->forget('carrinho');

            Log::critical('Pagamento aprovado, mas o pedido exige revisão manual.', [
                'venda_id' => $venda->id,
                'erro' => $exception->getMessage(),
            ]);

            return redirect('/biblioteca')->with(
                'erro',
                'O pagamento foi aprovado, mas houve uma alteração de estoque. Pedido ' . $venda->codigo_pedido . ' enviado para revisão.'
            );
        }

        session()->forget('carrinho');

        return redirect('/biblioteca')->with(
            'sucesso',
            'Pagamento aprovado pelo CaçaPay! Os jogos já estão disponíveis na sua biblioteca. Pedido ' . $venda->codigo_pedido . '.'
        );
    }

    public function biblioteca()
    {
        if (!$this->clienteLogado()) {
            return redirect('/login')->with('erro', 'Faça login como cliente para acessar sua biblioteca.');
        }

        $vendas = Venda::with('produtos.fotos')
            ->where('cliente_id', session('cliente_id'))
            ->whereIn('status', ['pagamento_aprovado', 'pago', 'revisao_manual'])
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

        $produtos = Produto::with('fotos')
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

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
