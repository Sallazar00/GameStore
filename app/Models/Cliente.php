<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'data_nascimento',
        'telefone',
        'email',
        'senha',
        'tipo',
    ];

    protected $hidden = ['senha'];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

    public function isAdmin(): bool
    {
        return $this->tipo === 'admin';
    }
}
