<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'chave_aleatoria',
        'id_cliente',
        'data_pedido',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->chave_aleatoria) {
                $model->chave_aleatoria = self::gerarChaveAleatoria();
            }
        });
    }

    /**
     * Gera uma chave aleatória única
     */
    public static function gerarChaveAleatoria(): string
    {
        $chave = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12));
        while (self::where('chave_aleatoria', $chave)->exists()) {
            $chave = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12));
        }
        return $chave;
    }

    /**
     * Relacionamento: Pedido pertence a um Cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    /**
     * Relacionamento: Pedido tem vários produtos
     */
    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(
            Produto::class,
            'pedido_produto',
            'id_pedido',
            'id_produto'
        )->withPivot('quantidade', 'preco_unitario');
    }
}
