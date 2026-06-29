<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $fillable = [
        'cliente_id',
        'descricao',
        'logradouro',
        'numero',
        'bairro',
        'cidade_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
