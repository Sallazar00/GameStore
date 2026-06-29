<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoProduto extends Model
{
    protected $table = 'fotos_produtos';

    protected $fillable = ['produto_id', 'nome_arquivo'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
