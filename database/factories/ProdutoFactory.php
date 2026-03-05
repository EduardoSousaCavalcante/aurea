<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'descricao' => $this->faker->sentence,
            'quantidade_por_caixa' => $this->faker->numberBetween(1, 100),
            'preco' => $this->faker->randomFloat(2, 0, 100),
            'estoque' => $this->faker->numberBetween(0, 50),
            'imagem' => null,
        ];
    }
}
