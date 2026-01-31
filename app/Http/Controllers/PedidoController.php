<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\PedidoProduto;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    // Listar pedidos
    public function index()
    {
        $pedidos = Pedido::orderBy('created_at', 'desc')->get();
        return view('dev.pedidos.index', compact('pedidos'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        $produtos = Produto::orderBy('nome')->get();
        return view('dev.pedidos.create', compact('produtos'));
    }

    // Salvar pedido
    public function store(Request $request)
    {
        $request->validate([
            'produtos' => 'required|array',
            'produtos.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Criar pedido
            $pedido = Pedido::create([
                'data_pedido' => now(),
            ]);

            foreach ($request->produtos as $idProduto => $quantidade) {
                if ($quantidade > 0) {
                    $produto = Produto::findOrFail($idProduto);

                    PedidoProduto::create([
                        'id_pedido' => $pedido->id,
                        'id_produto' => $produto->id,
                        'quantidade' => $quantidade,
                        'preco_unitario' => $produto->preco,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('pedidos.index')
                ->with('success', 'Pedido criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao criar pedido.');
        }
    }

    // Mostrar formulário de edição
    public function edit(Pedido $pedido)
    {
        $produtos = Produto::orderBy('nome')->get();
        $produtosPedido = $pedido->produtos()->pluck('quantidade', 'id_produto')->toArray();

        return view('dev.pedidos.edit', compact(
            'pedido',
            'produtos',
            'produtosPedido'
        ));
    }

    // Atualizar pedido
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'produtos' => 'required|array',
            'produtos.*' => 'integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Remove produtos antigos
            PedidoProduto::where('id_pedido', $pedido->id)->delete();

            // Insere novamente
            foreach ($request->produtos as $idProduto => $quantidade) {
                if ($quantidade > 0) {
                    $produto = Produto::findOrFail($idProduto);

                    PedidoProduto::create([
                        'id_pedido' => $pedido->id,
                        'id_produto' => $produto->id,
                        'quantidade' => $quantidade,
                        'preco_unitario' => $produto->preco,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('pedidos.index')
                ->with('success', 'Pedido atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar pedido.');
        }
    }

    // Deletar pedido
    public function destroy(Pedido $pedido)
    {
        DB::beginTransaction();

        try {
            PedidoProduto::where('id_pedido', $pedido->id)->delete();
            $pedido->delete();

            DB::commit();

            return redirect()->route('pedidos.index')
                ->with('success', 'Pedido deletado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao deletar pedido.');
        }
    }
}
