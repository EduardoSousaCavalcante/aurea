<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
