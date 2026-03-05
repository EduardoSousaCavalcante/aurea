<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Pedido;

class ProdutoEstoqueTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_reduces_when_order_created()
    {
        $produto = Produto::factory()->create(['estoque' => 10]);
        $cliente = Cliente::factory()->create();

        $response = $this->post(route('pedidos.store'), [
            'id_cliente' => $cliente->id,
            'produtos' => [ $produto->id => 3 ],
        ]);

        $produto->refresh();
        $this->assertEquals(7, $produto->estoque);
    }

    public function test_stock_restored_when_order_deleted()
    {
        $produto = Produto::factory()->create(['estoque' => 5]);
        $cliente = Cliente::factory()->create();

        $this->post(route('pedidos.store'), [
            'id_cliente' => $cliente->id,
            'produtos' => [ $produto->id => 2 ],
        ]);

        $pedido = Pedido::first();
        $this->delete(route('pedidos.destroy', $pedido));

        $produto->refresh();
        $this->assertEquals(5, $produto->estoque);
    }

    public function test_order_creation_fails_with_insufficient_stock()
    {
        $produto = Produto::factory()->create(['estoque' => 1]);
        $cliente = Cliente::factory()->create();

        $response = $this->post(route('pedidos.store'), [
            'id_cliente' => $cliente->id,
            'produtos' => [ $produto->id => 5 ],
        ]);

        $response->assertSessionHas('error');

        $produto->refresh();
        $this->assertEquals(1, $produto->estoque);
    }
}
