<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_pedido')->nullable()->unique();
            $table->foreignId('cliente_id')->constrained('clientes')->restrictOnDelete();
            $table->decimal('valor_total', 10, 2);
            $table->string('status')->default('aguardando_pagamento');
            $table->string('cacapay_transacao_id')->nullable();
            $table->string('cacapay_status')->nullable();
            $table->json('cacapay_resposta')->nullable();
            $table->timestamp('pago_em')->nullable();
            $table->text('integracao_erro')->nullable();
            $table->timestamps();
        });

        Schema::create('produto_venda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->constrained('vendas')->cascadeOnDelete();
            $table->foreignId('produto_id')->constrained('produtos')->restrictOnDelete();
            $table->integer('quantidade');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->unique(['venda_id', 'produto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produto_venda');
        Schema::dropIfExists('vendas');
    }
};
