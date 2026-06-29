<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\FotoProduto;
use App\Models\Plataforma;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $acao = Categoria::firstOrCreate(['nome' => 'Ação'], ['categoria_pai' => null]);
        $rpg = Categoria::firstOrCreate(['nome' => 'RPG'], ['categoria_pai' => null]);
        $aventura = Categoria::firstOrCreate(['nome' => 'Aventura'], ['categoria_pai' => null]);
        Categoria::firstOrCreate(['nome' => 'Terror'], ['categoria_pai' => null]);
        Categoria::firstOrCreate(['nome' => 'Estratégia'], ['categoria_pai' => null]);

        $pc = Plataforma::firstOrCreate(['nome' => 'PC']);
        Plataforma::firstOrCreate(['nome' => 'PlayStation']);
        Plataforma::firstOrCreate(['nome' => 'Xbox']);
        Plataforma::firstOrCreate(['nome' => 'Nintendo Switch']);

        $produtos = [
            [
                'nome' => 'Cyber Adventure',
                'descricao' => 'Jogo de aventura futurista em mundo aberto.',
                'quantidade_estoque' => 10,
                'slug' => 'cyber-adventure',
                'valor' => 59.90,
                'categoria_id' => $aventura->id,
                'plataforma_id' => $pc->id,
                'foto' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'nome' => 'Space Wars',
                'descricao' => 'Batalhas espaciais com naves e estratégia.',
                'quantidade_estoque' => 8,
                'slug' => 'space-wars',
                'valor' => 79.90,
                'categoria_id' => $acao->id,
                'plataforma_id' => $pc->id,
                'foto' => 'https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'nome' => 'Kingdom RPG',
                'descricao' => 'RPG medieval com classes, itens e exploração.',
                'quantidade_estoque' => 5,
                'slug' => 'kingdom-rpg',
                'valor' => 99.90,
                'categoria_id' => $rpg->id,
                'plataforma_id' => $pc->id,
                'foto' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=1200&auto=format&fit=crop',
            ],
        ];

        foreach ($produtos as $dados) {
            $foto = $dados['foto'];
            unset($dados['foto']);

            $produto = Produto::firstOrCreate(['slug' => $dados['slug']], $dados);

            FotoProduto::firstOrCreate([
                'produto_id' => $produto->id,
                'nome_arquivo' => $foto,
            ]);
        }
    }
}
