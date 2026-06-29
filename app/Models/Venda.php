<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

<<<<<<< HEAD
    protected $fillable = [
        'codigo_pedido',
        'cliente_id',
        'valor_total',
        'status',
        'cacapay_transacao_id',
        'cacapay_status',
        'cacapay_resposta',
        'pago_em',
        'integracao_erro',
    ];

    protected function casts(): array
    {
        return [
            'valor_total' => 'decimal:2',
            'cacapay_resposta' => 'array',
            'pago_em' => 'datetime',
        ];
    }
=======
    protected $fillable = ['cliente_id', 'endereco_id', 'valor_total'];
>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

<<<<<<< HEAD
=======
    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

>>>>>>> 1c0ba63effb3e71488a10871a5a571b652687b0a
    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_venda')
            ->withPivot('quantidade', 'subtotal')
            ->withTimestamps();
    }
}
