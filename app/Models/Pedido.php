<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'data_pedido',
    ];

    /**
     * Relacionamento: Pedido tem vários produtos
     */
    public function produtos()
    {
        return $this->belongsToMany(
            Produto::class,
            'pedido_produto',
            'id_pedido',
            'id_produto'
        )->withPivot('quantidade', 'preco_unitario');
    }
}
