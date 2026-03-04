<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pedido;

class Cliente extends Model
{
    protected $fillable = [
        'cnpj',
        'razao_social',
        'ie',
        'endereco',
        'cep',
        'apelido',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente');
    }
}