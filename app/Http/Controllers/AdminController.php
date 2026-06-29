<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
<<<<<<< HEAD
=======
use App\Models\Cidade;
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
use App\Models\FotoProduto;
use App\Models\Plataforma;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private function somenteAdmin()
    {
        if (session('cliente_tipo') !== 'admin') {
            abort(403, 'Acesso permitido apenas para administradores.');
        }
    }

    public function dashboard()
    {
        $this->somenteAdmin();

        return view('admin.dashboard', [
            'produtos' => Produto::count(),
            'categorias' => Categoria::count(),
<<<<<<< HEAD
=======
            'cidades' => Cidade::count(),
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
            'plataformas' => Plataforma::count(),
        ]);
    }

    public function categorias()
    {
        $this->somenteAdmin();

        return view('admin.categorias', [
            'categorias' => Categoria::with('pai')->orderBy('nome')->get(),
        ]);
    }

    public function salvarCategoria(Request $request)
    {
        $this->somenteAdmin();

        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria_pai' => 'nullable|exists:categorias,id',
        ]);

        Categoria::create($dados);

        return back()->with('sucesso', 'Categoria cadastrada.');
    }

    public function excluirCategoria(Categoria $categoria)
    {
        $this->somenteAdmin();

        if ($categoria->produtos()->exists() || $categoria->subcategorias()->exists()) {
            return back()->with('erro', 'Não é possível excluir uma categoria em uso.');
        }

        $categoria->delete();

        return back()->with('sucesso', 'Categoria excluída.');
    }

    public function plataformas()
    {
        $this->somenteAdmin();

        return view('admin.plataformas', [
            'plataformas' => Plataforma::orderBy('nome')->get(),
        ]);
    }

    public function salvarPlataforma(Request $request)
    {
        $this->somenteAdmin();

        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Plataforma::create(['nome' => $request->nome]);

        return back()->with('sucesso', 'Plataforma cadastrada.');
    }

    public function excluirPlataforma(Plataforma $plataforma)
    {
        $this->somenteAdmin();

        if ($plataforma->produtos()->exists()) {
            return back()->with('erro', 'Não é possível excluir uma plataforma em uso.');
        }

        $plataforma->delete();

        return back()->with('sucesso', 'Plataforma excluída.');
    }

<<<<<<< HEAD
=======
    public function cidades()
    {
        $this->somenteAdmin();

        return view('admin.cidades', [
            'cidades' => Cidade::orderBy('estado')->orderBy('nome')->get(),
        ]);
    }

    public function salvarCidade(Request $request)
    {
        $this->somenteAdmin();

        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
        ]);

        $dados['estado'] = strtoupper($dados['estado']);

        Cidade::create($dados);

        return back()->with('sucesso', 'Cidade cadastrada.');
    }

    public function excluirCidade(Cidade $cidade)
    {
        $this->somenteAdmin();

        if ($cidade->enderecos()->exists()) {
            return back()->with('erro', 'Não é possível excluir uma cidade em uso.');
        }

        $cidade->delete();

        return back()->with('sucesso', 'Cidade excluída.');
    }

>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
    public function produtos()
    {
        $this->somenteAdmin();

        return view('admin.produtos', [
            'produtos' => Produto::with(['categoria', 'plataforma', 'fotos'])->latest()->get(),
            'categorias' => Categoria::orderBy('nome')->get(),
            'plataformas' => Plataforma::orderBy('nome')->get(),
        ]);
    }

    public function salvarProduto(Request $request)
    {
        $this->somenteAdmin();

        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'quantidade_estoque' => 'required|integer|min:0',
            'valor' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'plataforma_id' => 'required|exists:plataformas,id',
            'url_imagem' => 'nullable|url',
            'fotos' => 'nullable|array|max:5',
            'fotos.*' => 'image|max:4096',
        ]);

        $totalFotos = 0;
        if ($request->filled('url_imagem')) {
            $totalFotos++;
        }
        if ($request->hasFile('fotos')) {
            $totalFotos += count($request->file('fotos'));
        }

        if ($totalFotos > 5) {
            return back()->withInput()->with('erro', 'Cada produto pode ter no máximo 5 fotos.');
        }

        $slugBase = Str::slug($request->nome);
        $slug = $slugBase;
        $contador = 2;

        while (Produto::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $contador;
            $contador++;
        }

        $valor = str_replace(',', '.', $request->valor);

        $produto = Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'quantidade_estoque' => $request->quantidade_estoque,
            'slug' => $slug,
            'valor' => $valor,
            'categoria_id' => $request->categoria_id,
            'plataforma_id' => $request->plataforma_id,
        ]);

        if ($request->filled('url_imagem')) {
            FotoProduto::create([
                'produto_id' => $produto->id,
                'nome_arquivo' => $request->url_imagem,
            ]);
        }

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $nomeArquivo = uniqid('produto_') . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('uploads/produtos'), $nomeArquivo);

                FotoProduto::create([
                    'produto_id' => $produto->id,
                    'nome_arquivo' => 'uploads/produtos/' . $nomeArquivo,
                ]);
            }
        }

        return back()->with('sucesso', 'Produto cadastrado e publicado na loja.');
    }

    public function excluirProduto(Produto $produto)
    {
        $this->somenteAdmin();

        foreach ($produto->fotos as $foto) {
            if (!Str::startsWith($foto->nome_arquivo, ['http://', 'https://'])) {
                File::delete(public_path($foto->nome_arquivo));
            }
        }

        $produto->fotos()->delete();
        $produto->delete();

        return back()->with('sucesso', 'Produto excluído da loja.');
    }
}
