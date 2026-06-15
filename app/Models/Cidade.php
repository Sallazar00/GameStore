<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = 'cidades';

    protected $fillable = ['nome', 'estado'];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }
}
