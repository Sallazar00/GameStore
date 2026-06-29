<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

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

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_venda')
            ->withPivot('quantidade', 'subtotal')
            ->withTimestamps();
    }
}
