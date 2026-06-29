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

<<<<<<< HEAD
=======
    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

    public function isAdmin(): bool
    {
        return $this->tipo === 'admin';
    }
}
