<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'quantidade_estoque',
        'slug',
        'valor',
        'categoria_id',
        'plataforma_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function plataforma()
    {
        return $this->belongsTo(Plataforma::class);
    }

    public function fotos()
    {
        return $this->hasMany(FotoProduto::class);
    }

    public function vendas()
    {
        return $this->belongsToMany(Venda::class, 'produto_venda')
            ->withPivot('quantidade', 'subtotal')
            ->withTimestamps();
    }
}
