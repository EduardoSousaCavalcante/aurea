<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'preco',
        'imagem',
    ];

    /**
     * Relacionamento: Produto pertence a vários pedidos
     */
    public function pedidos()
    {
        return $this->belongsToMany(
            Pedido::class,
            'pedido_produto',
            'id_produto',
            'id_pedido'
        )->withPivot('quantidade', 'preco_unitario');
    }
}
