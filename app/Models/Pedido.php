<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'chave_aleatoria',
        'id_cliente',
        'data_pedido',
        'data_entrega',
        'metodo_pagamento',
    ];

    protected $casts = [
        'data_pedido' => 'datetime',
        'data_entrega' => 'date',
    ];

    /**
     * Boot do model
     */
    protected static function booted(): void
    {
        static::creating(function ($pedido) {

            if (empty($pedido->chave_aleatoria)) {
                $pedido->chave_aleatoria = self::gerarChaveAleatoria();
            }

            if (empty($pedido->data_pedido)) {
                $pedido->data_pedido = now();
            }

        });
    }

    /**
     * Gera uma chave aleatória única
     */
    public static function gerarChaveAleatoria(): string
    {
        do {

            $chave = strtoupper(Str::random(12));

        } while (self::where('chave_aleatoria', $chave)->exists());

        return $chave;
    }

    /**
     * Pedido pertence a um Cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(
            Cliente::class,
            'id_cliente'
        );
    }

    /**
     * Pedido possui vários Produtos (tabela pivot)
     */
    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(
            Produto::class,
            'pedido_produto',
            'id_pedido',
            'id_produto'
        )
        ->withPivot([
            'quantidade',
            'preco_unitario'
        ])
        ->withTimestamps();
    }
}
